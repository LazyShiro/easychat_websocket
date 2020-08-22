<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace SwoftTest\WebSocket\Server\Testing;

use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Session\Session;
use Swoft\WebSocket\Server\Annotation\Mapping\OnClose;
use Swoft\WebSocket\Server\Annotation\Mapping\OnHandshake;
use Swoft\WebSocket\Server\Annotation\Mapping\OnOpen;
use Swoft\WebSocket\Server\Annotation\Mapping\WsModule;
use Swoft\WebSocket\Server\Contract\WsModuleInterface;
use Swoft\WebSocket\Server\MessageParser\JsonParser;
use SwoftTest\WebSocket\Server\Testing\Chat\ChatController;
use SwoftTest\WebSocket\Server\Testing\Chat\UserController;
use Swoole\WebSocket\Server;

/**
 * Class ChatModule
 *
 * @since 2.0
 *
 * @WsModule(
 *     path="/ws-test/chat",
 *     messageParser=JsonParser::class,
 *     controllers={UserController::class, ChatController::class}
 * )
 */
class ChatModule implements WsModuleInterface
{
    /**
     * 在这里你可以验证握手的请求信息
     * - 必须返回含有两个元素的array
     *  - 第一个元素的值来决定是否进行握手
     *  - 第二个元素是response对象
     * - 可以在response设置一些自定义header,body等信息
     *
     * @OnHandshake()
     * @param Request  $request
     * @param Response $response
     *
     * @return array
     * [ self::ACCEPT, $response ]
     */
    public function checkHandshake(Request $request, Response $response): array
    {
        Session::current()->set('handshake:' . $request->getUriPath(), __METHOD__);

        return [true, $response->withHeader('ws-conn', 'in testing')];
    }

    /**
     * @OnOpen()
     *
     * @param Request $request
     * @param int     $fd
     */
    public function onOpen(Request $request, int $fd): void
    {
        Session::current()->set("open:$fd:" . $request->getUriPath(), __METHOD__);
        Session::current()->push(__METHOD__);
    }

    /**
     * @OnClose()
     * on connection closed
     * - you can do something. eg. record log
     *
     * @param Server $server
     * @param int    $fd
     */
    public function onClose(Server $server, int $fd): void
    {
        Session::current()->set("close:$fd", __METHOD__);
    }

    /**
     * @return array
     * @todo
     */
    protected function configure(): array
    {
        return [
            'pingInterval' => 10000, // ms
            'pingTimeout'  => 5000, // ms
        ];
    }
}
