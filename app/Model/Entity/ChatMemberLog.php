<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 用户日志表
 * Class ChatMemberLog
 *
 * @since 2.0
 *
 * @Entity(table="chat_member_log")
 */
class ChatMemberLog extends Model
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
     * 附加数据
     *
     * @Column()
     *
     * @var string
     */
    private $data;

    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 类型 0禁止 1注册 2更改昵称 3更改密码 4更换头像 5更换个签 6更换性别 7更换在线状态
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
     * @return string
     */
    public function getData() : ?string
    {
        return $this->data;
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

    /**
     * @return int
     */
    public function getUid() : ?int
    {
        return $this->uid;
    }

}
