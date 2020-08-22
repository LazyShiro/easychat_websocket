<?php

namespace App\Model\Enum;

use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class FriendEnum
 *
 * @package App\Model\Enum
 * @Bean()
 */
class FriendEnum
{
    const APPLY  = 0;
    const ACCEPT = 1;
    const REFUSE = 2;
    const DELETE = 3;
    const BLACK  = 4;

    /**
     * 获取名称
     *
     * @param int $type
     *
     * @return string
     */
    public static function getEnumName(int $type)
    {
        $name = '';
        switch ($type) {
            case self::APPLY:
                $name = '申请';
                break;
            case self::ACCEPT:
                $name = '接受';
                break;
            case self::REFUSE:
                $name = '拒绝';
                break;
            case self::DELETE:
                $name = '删除';
                break;
            case self::BLACK:
                $name = '拉黑';
                break;
        }

        return $name;
    }

}
