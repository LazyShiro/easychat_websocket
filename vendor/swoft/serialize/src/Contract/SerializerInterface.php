<?php declare(strict_types=1);

namespace Swoft\Serialize\Contract;

/**
 * Class SerializerInterface
 *
 * @since 2.0.7
 */
interface SerializerInterface
{
    /**
     * @return bool
     */
    public static function isSupported(): bool;

    /**
     * @param array|object|mixed $data
     *
     * @return string
     */
    public function serialize($data): string;

    /**
     * @param string $string
     *
     * @return array|object
     */
    public function unserialize(string $string);
}
