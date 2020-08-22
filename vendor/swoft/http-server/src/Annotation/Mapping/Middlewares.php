<?php declare(strict_types=1);


namespace Swoft\Http\Server\Annotation\Mapping;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class Middlewares
 *
 * @since 2.0
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 * @Attributes({
 *     @Attribute("name", type="array"),
 * })
 */
final class Middlewares
{
    /**
     * Middlewares
     *
     * @var array
     *
     * @Required()
     */
    private $middlewares = [];

    /**
     * Middlewares constructor.
     *
     * @param $values
     */
    public function __construct($values)
    {
        if (isset($values['value'])) {
            $this->middlewares = $values['value'];
        }
        if (isset($values['middlewares'])) {
            $this->middlewares = $values['middlewares'];
        }
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}