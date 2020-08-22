<?php

namespace App\Model\Dao;

use App\Model\Entity\ChatRoom;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class RoomDao
 *
 * @package App\Model\Dao
 * @Bean()
 */
class RoomDao
{
    /**
     * @Inject()
     * @var ChatRoom
     */
    protected $roomModel;

    /**
     * 获取信息（通过房间号）
     *
     * @param string $roomNumber
     * @param array  $columns
     *
     * @return array
     */
    public function getInfoByRoomNumber(string $roomNumber, array $columns = ['*'])
    {
        $info = $this->roomModel->where(['number' => $roomNumber])->first($columns);
        if (!empty($info)) {
            return $info->toArray();
        } else {
            return [];
        }
    }

    /**
     * 获取信息（通过id）
     *
     * @param int   $roomId
     * @param array $columns
     *
     * @return array
     */
    public function getInfoByRoomId(int $roomId, array $columns = ['*'])
    {
        $info = $this->roomModel->where(['id' => $roomId])->first($columns);
        if (!empty($info)) {
            return $info->toArray();
        } else {
            return [];
        }
    }

    /**
     * 创建私聊房间
     *
     * @param string $roomNumber
     *
     * @return string
     */
    public function createRoomByPrivateChat(string $roomNumber)
    {
        return $this->roomModel->insertGetId(['number' => $roomNumber]);
    }

    /**
     * 创建群聊房间
     *
     * @param string $roomNumber
     * @param int    $uid
     * @param string $name
     * @param string $description
     * @param int    $memberMax
     *
     * @return string
     */
    public function createRoomGroupChat(string $roomNumber, int $uid, string $name, string $description, int $memberMax = 1)
    {
        return $this->roomModel->insertGetId(['number' => $roomNumber, 'uid' => $uid, 'name' => $name, 'description' => $description, 'membermax' => $memberMax, 'type' => 2]);
    }

}
