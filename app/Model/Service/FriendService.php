<?php

namespace App\Model\Service;

use App\Helper\MemoryTable;
use App\Model\Dao\FriendDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class FriendService
 *
 * @package App\Model\Data
 * @Bean()
 */
class FriendService
{
    /**
     * @Inject()
     * @var FriendDao
     */
    protected $friendModel;

    /**
     * 判断是否为好友关系
     *
     * @param int $uid
     * @param int $friendId
     *
     * @return mixed|null
     */
    public function friendStatus(int $uid, int $friendId)
    {
        $info = $this->friendModel->getInfoByUidFriendId($uid, $friendId, ['status']);

        if (empty($info)) {
            return NULL;
        } else {
            return $info['status'];
        }
    }

    /**
     * 获取用户的所有好友们的FD列表
     *
     * @param int $uid
     *
     * @return array
     */
    public function getFdList(int $uid)
    {
        /** @var FriendDao $friendModel */
        $friendModel = bean('App\Model\Dao\FriendDao');
        /** @var MemberService $memberService */
        $memberService = bean('App\Model\Service\MemberService');

        $friendList = $friendModel->getListByUid($uid, ['friendid']);

        if (empty($friendList)) {
            return [];
        }

        $friendFdList = [];
        foreach ($friendList as $value) {
            $friendFd = $memberService->getFdList($value['friendid']);
            if (empty($friendFd)) {
                continue;
            }
            foreach ($friendFd as $v) {
                array_push($friendFdList, $v);
            }
        }

        return $friendFdList;
    }

}
