<?php declare(strict_types=1);

namespace Swoft\Serialize;

use RuntimeException;
use Swoft\Serialize\Contract\SerializerInterface;
use function function_exists;

/**
 * Class MsgPackSerializer
 *
 * @since 1.0
 */
class MsgPackSerializer implements SerializerInterface
{
    /**
     * @return bool
     */
    public static function isSupported(): bool
    {
        return function_exists('msgpack_pack');
    }

    /**
     * Class constructor
     *
     * @throws RuntimeException
     */
    public function __construct()
    {
        if (!self::isSupported()) {
            throw new RuntimeException("The php extension 'msgpack' is required!");
        }
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    public function serialize($data): string
    {
        /** @noinspection PhpUndefinedFunctionInspection */
        return \msgpack_pack($data);
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function unserialize(string $string)
    {
        /** @noinspection PhpUndefinedFunctionInspection */
        return \msgpack_unpack($string);
    }
}
