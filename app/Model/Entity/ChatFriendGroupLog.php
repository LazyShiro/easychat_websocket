<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 好友分组日志表
 * Class ChatFriendGroupLog
 *
 * @since 2.0
 *
 * @Entity(table="chat_friend_group_log")
 */
class ChatFriendGroupLog extends Model
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
     * 附加信息
     *
     * @Column()
     *
     * @var string
     */
    private $data;

    /**
     * 分组id
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
     * 类型 0删除 1创建 2修改
     *
     * @Column()
     *
     * @var int
     */
    private $type;

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
     * @param string $data
     *
     * @return self
     */
    public function setData(string $data) : self
    {
        $this->data = $data;

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
     * @return int
     */
    public function getCreatetime() : ?int
    {
        return $this->createtime;
    }

    /**
     * @return string
     */
    public function getData() : ?string
    {
        return $this->data;
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
    public function getType() : ?int
    {
        return $this->type;
    }

}
