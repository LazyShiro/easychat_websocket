<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 房间日志表
 * Class ChatRoomLog
 *
 * @since 2.0
 *
 * @Entity(table="chat_room_log")
 */
class ChatRoomLog extends Model
{
    /**
     * 创建时间
     *
     * @Column()
     *
     * @var int
     */
    private $createtime;

    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 房间id
     *
     * @Column()
     *
     * @var int
     */
    private $roomid;

    /**
     * 类型 0删除 1正常 2异常
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 操作人id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * @param int $createtime
     *
     * @return self
     */
    public function setCreatetime(int $createtime) : self
    {
        $this->createtime = $createtime;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param int $roomid
     *
     * @return self
     */
    public function setRoomid(int $roomid) : self
    {
        $this->roomid = $roomid;

        return $this;
    }

    /**
     * @param int $type
     *
     * @return self
     */
    public function setType(int $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $uid
     *
     * @return self
     */
    public function setUid(int $uid) : self
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatetime() : ?int
    {
        return $this->createtime;
    }

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRoomid() : ?int
    {
        return $this->roomid;
    }

    /**
     * @return int
     */
    public function getType() : ?int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getUid() : ?int
    {
        return $this->uid;
    }

}
