<?php

namespace App\WebSocket\IM;

use App\Common\WsMessage;
use App\Helper\MemoryTable;
use App\Model\Dao\MemberDao;
use App\Model\Dao\RecordDao;
use App\Model\Dao\RoomDao;
use App\Model\Service\FriendService;
use App\Model\Service\MemberService;
use App\Model\Service\RoomService;
use Swoft\Task\Task;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;
use Swoft\WebSocket\Server\Annotation\Mapping\MessageMapping;
use Swoft\WebSocket\Server\Exception\WsServerException;
use Swoft\WebSocket\Server\Message\Message;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class ChatController
 * @WsController("chat")
 */
class ChatController
{
    /**
     * @Inject()
     * @var MemberService
     */
    protected $memberService;

    /**
     * @Inject()
     * @var FriendService
     */
    protected $friendService;

    /**
     * @Inject()
     * @var MemoryTable
     */
    protected $MemoryTable;

    /**
     * @Inject()
     * @var RoomService
     */
    protected $roomService;

    /**
     * @Inject()
     * @var RecordDao
     */
    protected $recordModel;

    /**
     * @Inject()
     * @var MemberDao
     */
    protected $memberModel;

    /**
     * @MessageMapping("sendMessage")
     */
    public function sendMessage(Message $message) : array
    {
        try {
            $data = $message->getData();

            if (!isset($data['friendId']) || empty($data['friendId'])) {
                return wsReturn(100002);
            }

            if (!isset($data['content']) || empty($data['content'])) {
                return wsReturn(300001);
            }

            $friendId = (int) de($data['friendId']);
            $content  = removeXSS($data['content']);
            $fd       = context()->getRequest()->getFd();
            $time     = time();

            //我的uid
            $uid = $this->MemoryTable->get(MemoryTable::FD_TO_USER, (string) $fd, 'uid');
            //我的个人信息
            $userInfo = $this->memberModel->getInfoById($uid, ['username', 'avatar']);
            //朋友的FD列表
            $friendFdList = $this->memberService->getFdList($friendId);
            //好友状态
            $friendStatus = $this->friendService->friendStatus($uid, $friendId);

            //非好友不能互动
            if ($friendStatus !== 1) {
                return wsReturn(100008);
            }

            //房间信息
            $roomInfo = $this->roomService->getRoomInfoByUidFriendId($uid, $friendId, ['id']);
            //消息入库
            $recordResult = (int) $this->recordModel->addDataByPrivateChat($roomInfo['id'], $uid, $content, $time);

            if ($recordResult !== 0) {
                Task::co('common', 'sendMessage', [$friendFdList, WsMessage::WS_CHAT_RECEIVE, wsReturn(["username" => $userInfo['username'], "avatar" => getAvatar($userInfo['avatar']), "id" => $uid, "type" => "friend", "content" => $content, "cid" => $recordResult, "mine" => FALSE, "fromid" => $uid, "timestamp" => $time * 1000,])]);
            }

            return wsReturn(["username" => $userInfo['username'], "avatar" => getAvatar($userInfo['avatar']), "id" => $uid, "type" => "friend", "content" => $content, "cid" => $recordResult, "mine" => TRUE, "fromid" => $uid, "timestamp" => $time * 1000,]);
        } catch (WsServerException $exception) {
            return wsReturn(900006, ['msg' => $exception->getMessage(), 'code' => $exception->getCode()]);
        }
    }

    /**
     * @MessageMapping("typingMessage")
     */
    public function typingMessage(Message $message) : array
    {
        try {
            $data = $message->getData();

            if (!isset($data['friendId']) || empty($data['friendId'])) {
                return wsReturn(100002);
            }

            if (!isset($data['content']) || empty($data['content'])) {
                return wsReturn(300001);
            }

            $friendId = (int) de($data['friendId']);
            $content  = removeXSS($data['content']);
            $fd       = context()->getRequest()->getFd();

            //我的uid
            $uid = $this->MemoryTable->get(MemoryTable::FD_TO_USER, (string) $fd, 'uid');
            //朋友的FD列表
            $friendFdList = $this->memberService->getFdList($friendId);
            //好友状态
            $friendStatus = $this->friendService->friendStatus($uid, $friendId);

            //非好友不能互动
            if ($friendStatus !== 1) {
                return wsReturn(100008);
            }

            vdump($friendFdList);
            Task::co('common', 'sendMessage', [$friendFdList, WsMessage::WS_CHAT_TYPING, wsReturn()]);

            return wsReturn();
        } catch (WsServerException $exception) {
            return wsReturn(900006, ['msg' => $exception->getMessage(), 'code' => $exception->getCode()]);
        }
    }

}
