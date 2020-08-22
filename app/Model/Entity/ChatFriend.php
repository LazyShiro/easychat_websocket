<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 好友关系表
 * Class ChatFriend
 *
 * @since 2.0
 *
 * @Entity(table="chat_friend")
 */
class ChatFriend extends Model
{
    /**
     * 朋友id
     *
     * @Column()
     *
     * @var int
     */
    private $friendid;

    /**
     * 好友分组id
     *
     * @Column()
     *
     * @var int
     */
    private $groupid;

    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 状态 0申请 1接受 2拒绝 3删除 4拉黑
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * @param int $friendid
     *
     * @return self
     */
    public function setFriendid(int $friendid) : self
    {
        $this->friendid = $friendid;

        return $this;
    }

    /**
     * @param int $groupid
     *
     * @return self
     */
    public function setGroupid(int $groupid) : self
    {
        $this->groupid = $groupid;

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
     * @param int $status
     *
     * @return self
     */
    public function setStatus(int $status) : self
    {
        $this->status = $status;

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
    public function getFriendid() : ?int
    {
        return $this->friendid;
    }

    /**
     * @return int
     */
    public function getGroupid() : ?int
    {
        return $this->groupid;
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
    public function getStatus() : ?int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getUid() : ?int
    {
        return $this->uid;
    }

}
