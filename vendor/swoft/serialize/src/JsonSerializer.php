<?php declare(strict_types=1);

namespace Swoft\Serialize;

use RuntimeException;
use Swoft\Serialize\Contract\SerializerInterface;
use function function_exists;
use function json_decode;
use function json_encode;
use function json_last_error;
use function json_last_error_msg;
use const JSON_ERROR_NONE;

/**
 * Class JsonSerializer
 *
 * @since 1.0
 */
class JsonSerializer implements SerializerInterface
{
    /**
     * @var bool
     */
    private $assoc = true;

    /**
     * @var int
     */
    private $encodeOption = 0;

    /**
     * @var int
     */
    private $decodeOption = 0;

    /**
     * @return bool
     */
    public static function isSupported(): bool
    {
        return function_exists('json_encode');
    }

    /**
     * Class constructor.
     *
     * @param null|bool $assoc
     */
    public function __construct($assoc = null)
    {
        if ($assoc !== null) {
            $this->setAssoc($assoc);
        }
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function unserialize(string $string)
    {
        $data = json_decode($string, $this->assoc, 512, $this->decodeOption);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('json_decode error: ' . json_last_error_msg());
        }

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    public function serialize($data): string
    {
        $string = json_encode($data, $this->encodeOption);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('json_decode error: ' . json_last_error_msg());
        }

        return $string;
    }

    /**
     * @return bool
     */
    public function isAssoc(): bool
    {
        return $this->assoc;
    }

    /**
     * @param bool $assoc
     */
    public function setAssoc($assoc): void
    {
        $this->assoc = (bool)$assoc;
    }

    /**
     * @return int
     */
    public function getEncodeOption(): int
    {
        return $this->encodeOption;
    }

    /**
     * @param int $encodeOption
     */
    public function setEncodeOption(int $encodeOption): void
    {
        $this->encodeOption = $encodeOption;
    }

    /**
     * @return int
     */
    public function getDecodeOption(): int
    {
        return $this->decodeOption;
    }

    /**
     * @param int $decodeOption
     */
    public function setDecodeOption(int $decodeOption): void
    {
        $this->decodeOption = $decodeOption;
    }
}
