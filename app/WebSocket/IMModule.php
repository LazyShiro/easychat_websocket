<?php declare(strict_types = 1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\WebSocket;

use app\data\enum\MemberEnum;
use App\Helper\Atomic;
use App\Helper\MemoryTable;
use App\Model\Dao\MemberDao;
use App\Model\Service\MemberService;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Task\Task;
use Swoft\WebSocket\Server\Annotation\Mapping\OnHandshake;
use Swoft\WebSocket\Server\Annotation\Mapping\OnOpen;
use Swoft\WebSocket\Server\Annotation\Mapping\OnClose;
use Swoft\WebSocket\Server\Annotation\Mapping\WsModule;
use App\WebSocket\IM\ChatController;
use App\WebSocket\IM\CommonController;
use App\WebSocket\IM\FriendController;
use App\WebSocket\IM\MemberController;
use Swoft\WebSocket\Server\MessageParser\JsonParser;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Class IMModule
 *
 * @WsModule(
 *     "/im",
 *     messageParser=JsonParser::class,
 *     controllers={
 *     ChatController::class,
 *     CommonController::class,
 *     FriendController::class,
 *     MemberController::class
 *     }
 * )
 */
class IMModule
{
    /**
     * @OnHandshake()
     * @param Request  $request
     * @param Response $response
     */
    public function checkHandshake(Request $request, Response $response) : array
    {
        $token = $request->getHeaderLine('sec-websocket-protocol');
        $token = authentication($token);
        $uid   = (int) de($token['id']);
        if ($uid === 0) return [FALSE, $response];

        /** @var MemberDao $memberModel */
        $memberModel = bean('App\Model\Dao\MemberDao');
        $userInfo    = $memberModel->getInfoById($uid, ['id']);
        if (empty($userInfo)) return [FALSE, $response];

        $request->uid = $uid;

        return [TRUE, $response];
    }

    /**
     * @OnOpen()
     * @param Request $request
     * @param int     $fd
     */
    public function onOpen(Request $request, int $fd) : void
    {
        /** @var MemoryTable $memoryTable */
        $memoryTable = bean('App\Helper\MemoryTable');
        /** @var MemberService $memberService */
        $memberService = bean('App\Model\Service\MemberService');

        //        $checkOnline = $memoryTable->get(MemoryTable::USER_TO_FD, (string) $request->uid, 'fd');
        //        if ($checkOnline) {
        //            \server()->sendTo($checkOnline, '你的帐号在别的地方登录！');
        //            \server()->disconnect($checkOnline);
        //        }
        //获取当前用户的FD列表
        $fdList = $memoryTable->get(MemoryTable::USER_TO_FD, (string) $request->uid, 'fdList');
        if ($fdList === FALSE) {
            //初始化当前用户FD列表
            $memoryTable->store(MemoryTable::USER_TO_FD, (string) $request->uid, ['fdList' => json_encode([$fd])]);
            $memberService->userChangeFettle($request->uid, MemberEnum::ONLINE);
        } else {
            //追加FD到当前用户的FD列表
            $fdList = json_decode($fdList, TRUE);
            array_push($fdList, $fd);
            $memoryTable->store(MemoryTable::USER_TO_FD, (string) $request->uid, ['fdList' => json_encode($fdList)]);
        }
        $memoryTable->store(MemoryTable::FD_TO_USER, (string) $fd, ['uid' => $request->uid]);
    }

    /**
     * @OnClose()
     * @param Server $server
     * @param int    $fd
     */
    public function onClose(Server $server, int $fd) : void
    {
        /** @var MemoryTable $memoryTable */
        $memoryTable = bean('App\Helper\MemoryTable');
        /** @var MemberService $memberService */
        $memberService = bean('App\Model\Service\MemberService');

        //获取我的uid，fd字符串，fd列表，定义新fd列表
        $uid       = $memoryTable->get(MemoryTable::FD_TO_USER, (string) $fd, 'uid');
        $fdString  = $memoryTable->get(MemoryTable::USER_TO_FD, (string) $uid, 'fdList');
        $fdList    = json_decode($fdString, TRUE);
        $fdListNew = [];

        foreach ($fdList as $value) {
            //如果是当前fd离线就把当前fd数据清空，否则把当前fd存入新fd列表
            if ($fd === $value) {
                $memoryTable->forget(MemoryTable::FD_TO_USER, (string) $fd);
            } else {
                array_push($fdListNew, $value);
            }
        }

        //如果fd列表只有一个值则把uid数据清除掉 并且 将该用户状态置为离线（说明该用户的所有客户端都下线了）
        if (count($fdList) === 1) {
            $memoryTable->forget(MemoryTable::USER_TO_FD, (string) $uid);
            $memberService->userChangeFettle($uid, MemberEnum::OFFLINE);
        }
        //如果新fd列表元素数量大于0则更新uid数据
        if (count($fdListNew) > 0) {
            $memoryTable->store(MemoryTable::USER_TO_FD, (string) $uid, ['fdList' => json_encode($fdListNew)]);
        }
    }

}
