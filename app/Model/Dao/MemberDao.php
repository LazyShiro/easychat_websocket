<?php declare(strict_types = 1);

namespace App\Model\Dao;

use App\Model\Entity\ChatMember;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class MemberDao
 *
 * @package App\Model\Dao
 * @Bean()
 */
class MemberDao
{
    /**
     * @Inject()
     * @var ChatMember
     */
    protected $memberModel;

    /**
     * 获取信息（通过id）
     *
     * @param int            $id
     * @param array|string[] $columns
     *
     * @return array
     */
    public function getInfoById(int $id, array $columns = ['*'])
    {
        $info = $this->memberModel->where(['id' => $id])->first($columns);
        if (!empty($info)) {
            return $info->toArray();
        } else {
            return [];
        }
    }

    /**
     * 获取数据（通过账号）
     *
     * @param string $account
     * @param string $field
     *
     * @return array
     */
    public function getInfoByAccount(string $account, string $field = '*')
    {
        $where = ['account' => $account];

        $info = $this->memberModel->where($where)->field($field)->find();
        if ($info != NULL) {
            return $info->toArray();
        } else {
            return [];
        }
    }

    /**
     * 用户注册
     *
     * @param string $account
     * @param string $password
     * @param string $salt
     *
     * @return int|string
     */
    public function register(string $account, string $password, string $salt)
    {
        return $this->memberModel->insertGetId(['username' => $account, 'account' => $account, 'password' => $password, 'salt' => $salt]);
    }

    /**
     * 更改昵称
     *
     * @param int    $uid
     * @param string $username
     *
     * @return bool
     */
    public function editUsername(int $uid, string $username)
    {
        return $this->memberModel->where(['id' => $uid])->update(['username' => $username]);
    }

    /**
     * 更改密码
     *
     * @param int    $uid
     * @param string $password
     *
     * @return bool
     */
    public function editPassword(int $uid, string $password)
    {
        return $this->memberModel->where(['id' => $uid])->update(['password' => $password]);
    }

    /**
     * 更改头像
     *
     * @param int $uid
     * @param int $avatar
     *
     * @return bool
     */
    public function editAvatar(int $uid, int $avatar)
    {
        return $this->memberModel->where(['id' => $uid])->update(['avatar' => $avatar]);
    }

    /**
     * 更改个签
     *
     * @param int    $uid
     * @param string $signature
     *
     * @return int
     */
    public function editSignature(int $uid, string $signature)
    {
        return $this->memberModel->where(['id' => $uid])->update(['signature' => $signature]);
    }

    /**
     * 更改性别
     *
     * @param int $uid
     * @param int $gender
     *
     * @return bool
     */
    public function editGender(int $uid, int $gender)
    {
        return $this->memberModel->where(['id' => $uid])->update(['gender' => $gender]);
    }

    /**
     * 更改在线状态
     *
     * @param int $uid
     * @param int $fettle
     *
     * @return int
     */
    public function editFettle(int $uid, int $fettle)
    {
        return $this->memberModel->where(['id' => $uid])->update(['fettle' => $fettle]);
    }

}
