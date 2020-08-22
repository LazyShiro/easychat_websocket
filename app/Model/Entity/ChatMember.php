<?php declare(strict_types = 1);

namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 用户表
 * Class ChatMember
 *
 * @since 2.0
 *
 * @Entity(table="chat_member")
 */
class ChatMember extends Model
{
    /**
     * 账号
     *
     * @Column()
     *
     * @var string
     */
    private $account;

    /**
     * 头像
     *
     * @Column()
     *
     * @var int
     */
    private $avatar;

    /**
     * 在线状态 0离线 1在线 2隐身 3忙碌 4离开
     *
     * @Column()
     *
     * @var int
     */
    private $fettle;

    /**
     * 性别 0未知 1男 2女
     *
     * @Column()
     *
     * @var int
     */
    private $gender;

    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 密码
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * 密码盐
     *
     * @Column()
     *
     * @var string
     */
    private $salt;

    /**
     * 个性签名
     *
     * @Column()
     *
     * @var string
     */
    private $signature;

    /**
     * 账号状态 0禁止 1正常
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 用户名
     *
     * @Column()
     *
     * @var string
     */
    private $username;

    /**
     * @param string $account
     *
     * @return self
     */
    public function setAccount(string $account) : self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @param int $avatar
     *
     * @return self
     */
    public function setAvatar(int $avatar) : self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @param int $fettle
     *
     * @return self
     */
    public function setFettle(int $fettle) : self
    {
        $this->fettle = $fettle;

        return $this;
    }

    /**
     * @param int $gender
     *
     * @return self
     */
    public function setGender(int $gender) : self
    {
        $this->gender = $gender;

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
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $salt
     *
     * @return self
     */
    public function setSalt(string $salt) : self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @param string $signature
     *
     * @return self
     */
    public function setSignature(string $signature) : self
    {
        $this->signature = $signature;

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
     * @param string $username
     *
     * @return self
     */
    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount() : ?string
    {
        return $this->account;
    }

    /**
     * @return int
     */
    public function getAvatar() : ?int
    {
        return $this->avatar;
    }

    /**
     * @return int
     */
    public function getFettle() : ?int
    {
        return $this->fettle;
    }

    /**
     * @return int
     */
    public function getGender() : ?int
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSalt() : ?string
    {
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getSignature() : ?string
    {
        return $this->signature;
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
    public function getUsername() : ?string
    {
        return $this->username;
    }

}
