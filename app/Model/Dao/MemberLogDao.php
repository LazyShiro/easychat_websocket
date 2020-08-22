<?php declare(strict_types = 1);

namespace App\Model\Dao;

use App\Model\Entity\ChatMemberLog;
use App\Model\Enum\MemberLogEnum;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class MemberLogDao
 *
 * @package App\Model\Dao
 * @Bean()
 */
class MemberLogDao
{
    /**
     * @Inject()
     * @var ChatMemberLog
     */
    protected $memberLogModel;

    /**
     * 添加记录（昵称）
     *
     * @param int    $uid
     * @param string $username
     *
     * @return string
     */
    public function addUsernameLog(int $uid, string $username)
    {
        return $this->memberLogModel->insertGetId(['uid' => $uid, 'type' => MemberLogEnum::NICKNAME, 'data' => $username, 'createtime' => time()]);
    }

    /**
     * 添加记录（密码）
     *
     * @param int    $uid
     * @param string $password
     *
     * @return string
     */
    public function addPasswordLog(int $uid, string $password)
    {
        return $this->memberLogModel->insertGetId(['uid' => $uid, 'type' => MemberLogEnum::PASSWORD, 'data' => $password, 'createtime' => time()]);
    }

    /**
     * 添加记录（头像）
     *
     * @param int $uid
     * @param int $avatar
     *
     * @return string
     */
    public function addAvatarLog(int $uid, int $avatar)
    {
        return $this->memberLogModel->insertGetId(['uid' => $uid, 'type' => MemberLogEnum::AVATAR, 'data' => $avatar, 'createtime' => time()]);
    }

    /**
     * 添加记录（个签）
     *
     * @param int    $uid
     * @param string $signature
     *
     * @return string
     */
    public function addSignatureLog(int $uid, string $signature)
    {
        return $this->memberLogModel->insertGetId(['uid' => $uid, 'type' => MemberLogEnum::SIGNATURE, 'data' => $signature, 'createtime' => time()]);
    }

    /**
     * 添加记录（性别）
     *
     * @param int $uid
     * @param int $gender
     *
     * @return string
     */
    public function addGenderLog(int $uid, int $gender)
    {
        return $this->memberLogModel->insertGetId(['uid' => $uid, 'type' => MemberLogEnum::GENDER, 'data' => $gender, 'createtime' => time()]);
    }

    /**
     * 添加记录（在线状态）
     *
     * @param int $uid
     * @param int $fettle
     *
     * @return string
     */
    public function addFettleLog(int $uid, int $fettle)
    {
        return $this->memberLogModel->insertGetId(['uid' => $uid, 'type' => MemberLogEnum::FETTLE, 'data' => $fettle, 'createtime' => time()]);
    }

}
