<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 房间表
 * Class ChatRoom
 *
 * @since 2.0
 *
 * @Entity(table="chat_room")
 */
class ChatRoom extends Model
{
    /**
     * 房间描述
     *
     * @Column()
     *
     * @var string
     */
    private $description;

    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 房间当前人数
     *
     * @Column()
     *
     * @var int
     */
    private $membercount;

    /**
     * 房间最大人数限制 1为不限制
     *
     * @Column()
     *
     * @var int
     */
    private $membermax;

    /**
     * 房间名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 房间号
     *
     * @Column()
     *
     * @var string
     */
    private $number;

    /**
     * 状态 0删除 1正常 2异常
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 类型 0私聊 1群聊
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 创建者uid
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription(string $description) : self
    {
        $this->description = $description;

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
     * @param int $membercount
     *
     * @return self
     */
    public function setMembercount(int $membercount) : self
    {
        $this->membercount = $membercount;

        return $this;
    }

    /**
     * @param int $membermax
     *
     * @return self
     */
    public function setMembermax(int $membermax) : self
    {
        $this->membermax = $membermax;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $number
     *
     * @return self
     */
    public function setNumber(string $number) : self
    {
        $this->number = $number;

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
     * @return string
     */
    public function getDescription() : ?string
    {
        return $this->description;
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
    public function getMembercount() : ?int
    {
        return $this->membercount;
    }

    /**
     * @return int
     */
    public function getMembermax() : ?int
    {
        return $this->membermax;
    }

    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNumber() : ?string
    {
        return $this->number;
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
