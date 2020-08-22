<?php declare(strict_types=1);

namespace Swoft\Serialize\Concern;

use Swoft\Serialize\Contract\SerializerInterface;
use Swoft\Serialize\PhpSerializer;

/**
 * Class SerializeAwareTrait
 *
 * @since 1.0
 */
trait SerializerAwareTrait
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        if (!$this->serializer) {
            $this->serializer = new PhpSerializer();
        }

        return $this->serializer;
    }

    /**
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}
