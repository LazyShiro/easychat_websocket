<?php

namespace App\Model\Service;

use App\Model\Dao\RoomDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class RoomService
 *
 * @package App\Model\Service
 * @Bean()
 */
class RoomService
{
    /**
     * @Inject()
     * @var RoomDao
     */
    protected $roomModel;

    /**
     * 获取房间信息（通过私聊双方id）
     *
     * @param int   $uid
     * @param int   $friendId
     * @param array $columns
     *
     * @return array
     */
    public function getRoomInfoByUidFriendId(int $uid, int $friendId, array $columns = ['*'])
    {
        $roomNumber = getRoomNumber($uid, $friendId);
        $roomInfo   = $this->roomModel->getInfoByRoomNumber($roomNumber, $columns);
        if (empty($roomInfo)) {
            $roomId   = $this->roomModel->createRoomByPrivateChat($roomNumber);
            $roomInfo = $this->roomModel->getInfoByRoomId($roomId, $columns);
        }

        return $roomInfo;
    }

}
