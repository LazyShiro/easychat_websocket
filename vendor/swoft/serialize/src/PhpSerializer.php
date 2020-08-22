<?php declare(strict_types=1);

namespace Swoft\Serialize;

use Swoft\Serialize\Contract\SerializerInterface;
use function function_exists;
use function serialize;
use function unserialize;

/**
 * Class PhpSerializer
 *
 * @since 1.0
 */
class PhpSerializer implements SerializerInterface
{
    /**
     * @var array
     */
    private $options = ['allowed_classes' => false];

    /**
     * @return bool
     */
    public static function isSupported(): bool
    {
        return function_exists('serialize');
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    public function serialize($data): string
    {
        return serialize($data);
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function unserialize(string $string)
    {
        return unserialize($string, $this->options);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
