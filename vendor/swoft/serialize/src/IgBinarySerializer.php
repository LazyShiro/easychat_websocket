<?php declare(strict_types=1);

namespace Swoft\Serialize;

use RuntimeException;
use Swoft\Serialize\Contract\SerializerInterface;
use function extension_loaded;

/**
 * Class IgBinarySerializer
 *
 * @since 2.0
 */
class IgBinarySerializer implements SerializerInterface
{
    /**
     * @return bool
     */
    public static function isSupported(): bool
    {
        return extension_loaded('igbinary');
    }

    /**
     * Class constructor
     *
     * @throws RuntimeException
     */
    public function __construct()
    {
        if (!self::isSupported()) {
            throw new RuntimeException("The php extension 'igbinary' is required!");
        }
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    public function serialize($data): string
    {
        /** @noinspection PhpComposerExtensionStubsInspection */
        return \igbinary_serialize($data);
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function unserialize(string $string)
    {
        /** @noinspection PhpComposerExtensionStubsInspection */
        return \igbinary_unserialize($string);
    }
}
