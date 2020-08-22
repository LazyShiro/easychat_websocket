<?php

namespace App\Model\Enum;

use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class MemberLogEnum
 *
 * @package App\Model\Enum
 * @Bean()
 */
class MemberLogEnum
{
    const NICKNAME  = 2;
    const PASSWORD  = 3;
    const AVATAR    = 4;
    const SIGNATURE = 5;
    const GENDER    = 6;
    const FETTLE    = 7;

    /**
     * 获取名称
     *
     * @param int $type
     *
     * @return string
     */
    public static function getEnumName(int $type)
    {
        switch ($type) {
            case self::NICKNAME:
                $name = '昵称';
                break;
            case self::PASSWORD:
                $name = '密码';
                break;
            case self::AVATAR:
                $name = '头像';
                break;
            case self::SIGNATURE:
                $name = '个签';
                break;
            case self::GENDER:
                $name = '性别';
                break;
            case self::FETTLE:
                $name = '在线状态';
                break;
            default:
                $name = '';
                break;
        }

        return $name;
    }

}
