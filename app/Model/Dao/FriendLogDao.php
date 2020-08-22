<?php

namespace App\Model\Dao;

use App\Model\Entity\ChatFriendLog;
use App\Model\Enum\FriendEnum;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class FriendLogDao
 *
 * @package App\Model\Dao
 * @Bean()
 */
class FriendLogDao
{
    /**
     * @Inject()
     * @var ChatFriendLog
     */
    protected $friendLogModel;

    /**
     * 申请日志
     *
     * @param int    $uid
     * @param int    $friendId
     * @param int    $groupId
     * @param string $remark
     *
     * @return string
     */
    public function addApplyLog(int $uid, int $friendId, int $groupId, string $remark)
    {
        return $this->friendLogModel->insertGetId(['uid' => $uid, 'friendid' => $friendId, 'groupid' => $groupId, 'type' => FriendEnum::APPLY, 'remark' => $remark, 'createtime' => time()]);
    }

    /**
     * 获取最近一条申请信息
     *
     * @param int            $uid
     * @param int            $friendId
     * @param array|string[] $columns
     *
     * @return array
     */
    public function getRecentApplyData(int $uid, int $friendId, array $columns = ['*'])
    {
        $where = ['uid' => $friendId, 'friendid' => $uid, 'type' => 0];

        $info = $this->friendLogModel->where($where)->first($columns);
        if ($info != NULL) {
            return $info->toArray();
        } else {
            return [];
        }
    }

    /**
     * 编辑好友请求数据
     *
     * @param int $id
     * @param int $type
     *
     * @return int
     */
    public function editFriendApply(int $id, int $type)
    {
        $where = ['id' => $id];
        $data  = ['type' => $type];

        return $this->friendLogModel->where($where)->update($data);
    }

}
