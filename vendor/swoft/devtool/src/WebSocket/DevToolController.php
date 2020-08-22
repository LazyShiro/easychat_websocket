<?php declare(strict_types=1);

namespace Swoft\Devtool\WebSocket;

use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

// use Swoft\WebSocket\Server\Bean\Annotation\WebSocket;

/**
 * Class DevToolController
 *
 * @see     \Swoft\WebSocket\Server\HandlerInterface
 * @package Swoft\Devtool\WebSocket
 * - Remove dependency on 'websocket-server'
 * WsModule("/__devtool")
 */
class DevToolController
{
    /**
     * {@inheritdoc}
     */
    public function checkHandshake(Request $request, Response $response): array
    {
        return [0, $response];
    }

    /**
     * @param Server  $server
     * @param Request $request
     * @param int     $fd
     */
    public function onOpen(Server $server, Request $request, int $fd)
    {
        $server->push($fd, 'hello, welcome to devtool! :)');
    }

    /**
     * @param Server $server
     * @param Frame  $frame
     */
    public function onMessage(Server $server, Frame $frame)
    {
        $server->push($frame->fd, 'hello, I have received your message: ' . $frame->data);
    }

    /**
     * @param Server $server
     * @param int    $fd
     */
    public function onClose(Server $server, int $fd)
    {
        // $server->push($fd, 'ooo, goodbye! :)');
    }
}
