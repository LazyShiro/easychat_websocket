<?php

namespace app\data\enum;

use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class MemberEnum
 *
 * @package app\data\enum
 * @Bean()
 */
class MemberEnum
{
    const OFFLINE = 0;
    const ONLINE  = 1;
    const HIDE    = 2;
    const BUSY    = 3;
    const LEAVE   = 4;

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
            case self::OFFLINE:
                $name = 'offline';
                break;
            case self::ONLINE:
                $name = 'online';
                break;
            case self::HIDE:
                $name = 'stealth';
                break;
            case self::BUSY:
                $name = 'busy';
                break;
            case self::LEAVE:
                $name = 'leave';
                break;
            default:
                $name = '';
                break;
        }

        return $name;
    }

    /**
     * 获取code
     *
     * @param string $name
     *
     * @return int
     */
    public static function getEnumCode(string $name)
    {
        switch ($name) {
            case 'offline':
                $code = 0;
                break;
            case 'online':
                $code = 1;
                break;
            case 'hide':
                $code = 2;
                break;
            case 'busy':
                $code = 3;
                break;
            case 'leave':
                $code = 4;
                break;
            default:
                $code = - 1;
                break;
        }

        return $code;
    }

}
