<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 好友分组表
 * Class ChatFriendGroup
 *
 * @since 2.0
 *
 * @Entity(table="chat_friend_group")
 */
class ChatFriendGroup extends Model
{
    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 状态 0删除 1正常
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 分组名称
     *
     * @Column()
     *
     * @var string
     */
    private $title;

    /**
     * 类型 0系统 1自定
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
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;

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
     * @return string
     */
    public function getTitle() : ?string
    {
        return $this->title;
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
