<?php declare(strict_types = 1);

namespace App\WebSocket\IM;

use App\Common\WsMessage;
use App\Helper\MemoryTable;
use App\Model\Dao\FriendDao;
use App\Model\Dao\FriendLogDao;
use App\Model\Dao\MemberDao;
use App\Model\Service\FriendService;
use App\Model\Enum\FriendEnum;
use Swoft\Task\Task;
use Swoft\WebSocket\Server\Exception\WsServerException;
use Swoft\WebSocket\Server\Message\Message;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;
use Swoft\WebSocket\Server\Annotation\Mapping\MessageMapping;

/**
 * Class FriendController
 *
 * @WsController("friend")
 */
class FriendController
{
    /**
     * @MessageMapping("addFriend")
     */
    public function addFriend(Message $message) : array
    {
        try {
            $data = $message->getData();

            if (!isset($data['friendId']) || empty($data['friendId'])) {
                return wsReturn(100002);
            }

            if (!isset($data['groupId']) || empty($data['groupId'])) {
                return wsReturn(400001);
            }

            $friendId = (int) de($data['friendId']);
            $groupId  = (int) de($data['groupId']);
            $remark   = removeXSS($data['remark']);
            $fd       = context()->getRequest()->getFd();

            //好友id错误
            if ($friendId === 0) {
                return wsReturn(100002);
            }

            //好友分组id错误
            if ($groupId === 0) {
                return wsReturn(400001);
            }

            /** @var MemoryTable $MemoryTable */
            $MemoryTable = bean('App\Helper\MemoryTable');
            /** @var FriendDao $friendModel */
            $friendModel = bean('App\Model\Dao\FriendDao');
            /** @var FriendLogDao $friendLogModel */
            $friendLogModel = bean('App\Model\Dao\FriendLogDao');
            /** @var FriendService $friendService */
            $friendService = bean('App\Model\Service\FriendService');

            //我的uid
            $uid = $MemoryTable->get(MemoryTable::FD_TO_USER, (string) $fd, 'uid');
            //朋友的FD
            $friendFd     = $MemoryTable->get(MemoryTable::USER_TO_FD, (string) $friendId, 'fdList');
            $friendFdList = json_decode($friendFd, TRUE);

            //不能添加自己为好友
            if ($uid === $friendId) {
                return wsReturn(100006);
            }

            //好友状态
            $friendStatus = $friendService->friendStatus($uid, $friendId);

            //已经是好友关系
            if ($friendStatus === 1) {
                return wsReturn(100003);
            }
            //被拉黑
            if ($friendStatus === 4) {
                return wsReturn(100004);
            }
            //正在申请
            if ($friendStatus === 0) {
                return wsReturn(100005);
            }

            //添加好友（申请）
            $friendResult = (int) $friendModel->addFriend($uid, $friendId, $groupId);
            //新增好友申请记录
            $friendLogResult = (int) $friendLogModel->addApplyLog($uid, $friendId, $groupId, $remark);

            if ($friendResult !== 0 && $friendLogResult !== 0) {
                $count = $friendModel->getCountByApply($uid);
                Task::co('common', 'sendMessage', [$friendFdList, WsMessage::WS_FRIEND_APPLY, wsReturn(['count' => $count])]);

                return wsReturn();
            } else {
                return wsReturn(900004);
            }
        } catch (WsServerException $exception) {
            return wsReturn(900006, ['msg' => $exception->getMessage(), 'code' => $exception->getCode()]);
        }
    }

    /**
     * @MessageMapping("acceptFriend")
     */
    public function acceptFriend(Message $message) : array
    {
        try {
            $data = $message->getData();

            if (!isset($data['friendId']) || empty($data['friendId'])) {
                return wsReturn(100002);
            }

            if (!isset($data['groupId']) || empty($data['groupId'])) {
                return wsReturn(400001);
            }

            $friendId = (int) de($data['friendId']);
            $groupId  = (int) de($data['groupId']);
            $fd       = context()->getRequest()->getFd();

            //好友id错误
            if ($friendId === 0) {
                return wsReturn(100002);
            }

            //好友分组id错误
            if ($groupId === 0) {
                return wsReturn(400001);
            }

            /** @var MemoryTable $MemoryTable */
            $MemoryTable  = bean('App\Helper\MemoryTable');
            $uid          = $MemoryTable->get(MemoryTable::FD_TO_USER, (string) $fd, 'uid');
            $friendFd     = $MemoryTable->get(MemoryTable::USER_TO_FD, (string) $friendId, 'fdList');
            $friendFdList = json_decode($friendFd, TRUE);

            //不能添加自己为好友
            if ($uid === $friendId) {
                return wsReturn(100006);
            }

            /** @var FriendDao $friendModel */
            $friendModel = bean('App\Model\Dao\FriendDao');
            /** @var FriendLogDao $friendLogModel */
            $friendLogModel = bean('App\Model\Dao\FriendLogDao');
            /** @var MemberDao $memberModel */
            $memberModel = bean('App\Model\Dao\MemberDao');
            /** @var FriendService $friendService */
            $friendService = bean('App\Model\Service\FriendService');

            $friendStatus = $friendService->friendStatus($uid, $friendId);

            //已经是好友关系
            if ($friendStatus === 1) {
                return wsReturn(100003);
            }

            $friendResult    = (int) $friendModel->acceptFriend($uid, $friendId, $groupId);
            $friendApplyInfo = $friendLogModel->getRecentApplyData($uid, $friendId, ['id', 'groupid']);
            $friendLogResult = (int) $friendLogModel->editFriendApply($friendApplyInfo['id'], FriendEnum::ACCEPT);

            if ($friendResult !== 0 && $friendLogResult !== 0) {
                $userInfo   = $memberModel->getInfoById($uid, ['avatar', 'username', 'signature']);
                $friendInfo = $memberModel->getInfoById($friendId, ['avatar', 'username', 'signature']);
                Task::co('common', 'sendMessage', [$friendFdList, WsMessage::WS_FRIEND_ACCEPT, wsReturn(["type" => 'friend', "avatar" => getAvatar($userInfo['avatar']), "username" => $userInfo['username'], "groupid" => $friendApplyInfo['groupid'], "id" => $uid, "sign" => $userInfo['signature']])]);

                return wsReturn(["type" => 'friend', "avatar" => getAvatar($friendInfo['avatar']), "username" => $friendInfo['username'], "groupid" => $groupId, "id" => $friendId, "sign" => $friendInfo['signature'], "friendLogId" => $friendApplyInfo['id'],]);
            } else {
                return wsReturn(900004);
            }
        } catch (WsServerException $exception) {
            return wsReturn(900006, ['msg' => $exception->getMessage(), 'code' => $exception->getCode()]);
        }
    }

}
