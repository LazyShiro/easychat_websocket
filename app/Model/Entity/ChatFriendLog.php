<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 好友关系日志表
 * Class ChatFriendLog
 *
 * @since 2.0
 *
 * @Entity(table="chat_friend_log")
 */
class ChatFriendLog extends Model
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
     * 好友id
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
     * 状态 0未读 1已读
     *
     * @Column()
     *
     * @var int
     */
    private $read;

    /**
     * 好友验证消息
     *
     * @Column()
     *
     * @var string
     */
    private $remark;

    /**
     * 类型 0请求 1接受 2拒绝 3删除 4拉黑
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 用户id
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
     * @param int $read
     *
     * @return self
     */
    public function setRead(int $read) : self
    {
        $this->read = $read;

        return $this;
    }

    /**
     * @param string $remark
     *
     * @return self
     */
    public function setRemark(string $remark) : self
    {
        $this->remark = $remark;

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
    public function getRead() : ?int
    {
        return $this->read;
    }

    /**
     * @return string
     */
    public function getRemark() : ?string
    {
        return $this->remark;
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
