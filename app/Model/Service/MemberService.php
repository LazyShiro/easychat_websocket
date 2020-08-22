<?php

namespace App\Model\Service;

use App\Common\WsMessage;
use app\data\enum\MemberEnum;
use App\Helper\MemoryTable;
use App\Model\Dao\FriendDao;
use App\Model\Dao\MemberDao;
use App\Model\Dao\MemberLogDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Task\Task;

/**
 * Class MemberService
 *
 * @package App\Model\Service
 * @Bean()
 */
class MemberService
{
    /**
     * @Inject()
     * @var MemberDao
     */
    protected $memberModel;

    /**
     * @Inject()
     * @var MemberLogDao
     */
    protected $memberLogModel;

    /**
     * @Inject()
     * @var FriendService
     */
    protected $friendService;

    /**
     * 用户改变状态
     *
     * @param int $uid
     * @param int $fettle
     */
    public function userChangeFettle(int $uid, int $fettle)
    {

        $this->memberModel->editFettle($uid, $fettle);
        $this->memberLogModel->addFettleLog($uid, $fettle);
        $friendFdList = $this->friendService->getFdList($uid);

        Task::co('common', 'sendMessage', [$friendFdList, WsMessage::WS_FRIEND_FETTLE, wsReturn(["id" => $uid, "status" => MemberEnum::getEnumName($this->getFriendShouldKnowFettle($fettle)),])]);
    }

    /**
     * 用户修改个签
     *
     * @param int    $uid
     * @param string $signature
     *
     * @return int
     */
    public function userChangeSignature(int $uid, string $signature)
    {
        $memberResult = $this->memberModel->editSignature($uid, $signature);
        $this->memberLogModel->addSignatureLog($uid, $signature);

        return $memberResult;
    }

    /**
     * 获取用户的FD列表
     *
     * @param int $uid
     *
     * @return array|mixed
     */
    public function getFdList(int $uid)
    {
        /** @var MemoryTable $MemoryTable */
        $MemoryTable = bean('App\Helper\MemoryTable');

        $friendFd     = $MemoryTable->get(MemoryTable::USER_TO_FD, (string) $uid, 'fdList');
        $friendFdList = json_decode($friendFd, TRUE);

        if (empty($friendFdList)) {
            return [];
        }

        return $friendFdList;
    }

    /**
     * 获取好友们应该收到的在线状态
     *
     * @param int $fettle
     *
     * @return int
     */
    public function getFriendShouldKnowFettle(int $fettle)
    {
        if ($fettle === MemberEnum::OFFLINE) {
            return $fettle;
        }

        if ($fettle === MemberEnum::ONLINE) {
            return $fettle;
        }

        if ($fettle === MemberEnum::HIDE) {
            return MemberEnum::OFFLINE;
        }

        if ($fettle === MemberEnum::BUSY) {
            return $fettle;
        }

        if ($fettle === MemberEnum::LEAVE) {
            return $fettle;
        }

        return MemberEnum::OFFLINE;
    }

}
