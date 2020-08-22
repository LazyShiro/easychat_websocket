<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 聊天记录表
 * Class ChatRecord
 *
 * @since 2.0
 *
 * @Entity(table="chat_record")
 */
class ChatRecord extends Model
{
    /**
     * 内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     * 创建时间
     *
     * @Column()
     *
     * @var int
     */
    private $createtime;

    /**
     * 删除时间
     *
     * @Column()
     *
     * @var int
     */
    private $deletetime;

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
     * 状态 0撤回 1正常 2删除
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 发送者id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 更新时间
     *
     * @Column()
     *
     * @var int
     */
    private $updatetime;

    /**
     * @param string $content
     *
     * @return self
     */
    public function setContent(string $content) : self
    {
        $this->content = $content;

        return $this;
    }

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
     * @param int $deletetime
     *
     * @return self
     */
    public function setDeletetime(int $deletetime) : self
    {
        $this->deletetime = $deletetime;

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
     * @param int $updatetime
     *
     * @return self
     */
    public function setUpdatetime(int $updatetime) : self
    {
        $this->updatetime = $updatetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : ?string
    {
        return $this->content;
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
    public function getDeletetime() : ?int
    {
        return $this->deletetime;
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

    /**
     * @return int
     */
    public function getUpdatetime() : ?int
    {
        return $this->updatetime;
    }

}
