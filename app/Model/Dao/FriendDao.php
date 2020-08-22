<?php declare(strict_types = 1);

namespace App\Model\Dao;

use App\Model\Entity\ChatFriend;
use App\Model\Enum\FriendEnum;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class FriendDao
 *
 * @package App\Model\Dao
 * @Bean()
 */
class FriendDao
{
    /**
     * @Inject()
     * @var ChatFriend
     */
    protected $friendModel;

    /**
     * 获取信息（通过用户id好友id）
     *
     * @param int            $uid
     * @param int            $friendId
     * @param array|string[] $columns
     *
     * @return array
     */
    public function getInfoByUidFriendId(int $uid, int $friendId, array $columns = ['*'])
    {
        $info = $this->friendModel->where(['uid' => $uid, 'friendid' => $friendId])->first($columns);
        if (!empty($info)) {
            return $info->toArray();
        } else {
            return [];
        }
    }

    /**
     * 获取列表（通过uid）
     *
     * @param int   $uid
     * @param array $columns
     *
     * @return array
     */
    public function getListByUid(int $uid, array $columns = ['*'])
    {
        $list = $this->friendModel->where(['uid' => $uid, 'status' => FriendEnum::ACCEPT])->get($columns);
        if ($list != NULL) {
            return $list->toArray();
        } else {
            return [];
        }
    }

    /**
     * 获取数量（通过好友申请）
     *
     * @param int $uid
     *
     * @return int
     */
    public function getCountByApply(int $uid)
    {
        return $this->friendModel->where(['uid' => $uid, 'status' => 0])->count();
    }

    /**
     * 添加好友（申请）
     *
     * @param int $uid
     * @param int $friendId
     * @param int $groupId
     *
     * @return string
     */
    public function addFriend(int $uid, int $friendId, int $groupId)
    {
        return $this->friendModel->insertGetId(['uid' => $uid, 'groupid' => $groupId, 'friendid' => $friendId, 'status' => FriendEnum::APPLY]);
    }

    /**
     * 添加好友（通过）
     *
     * @param int $uid
     * @param int $friendId
     * @param int $groupId
     *
     * @return bool
     */
    public function acceptFriend(int $uid, int $friendId, int $groupId)
    {
        $this->friendModel->where(['uid' => $friendId, 'friendid' => $uid])->update(['status' => FriendEnum::ACCEPT]);
        $this->friendModel->insert(['uid' => $uid, 'friendid' => $friendId, 'groupid' => $groupId, 'status' => FriendEnum::ACCEPT]);

        return TRUE;
    }

}
