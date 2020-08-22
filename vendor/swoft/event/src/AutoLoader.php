<?php declare(strict_types=1);

namespace Swoft\Event;

use Swoft\Event\Manager\EventManager;
use Swoft\Helper\ComposerJSON;
use Swoft\SwoftComponent;
use function dirname;

/**
 * Class AutoLoader
 *
 * @since 2.0.0
 */
class AutoLoader extends SwoftComponent
{
    /**
     * Metadata information for the component
     *
     * @return array
     */
    public function metadata(): array
    {
        $jsonFile = dirname(__DIR__) . '/composer.json';

        return ComposerJSON::open($jsonFile)->getMetadata();
    }

    /**
     * Get namespace and dir
     *
     * @return array
     * [
     *     namespace => dir path
     * ]
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

    /**
     * @return array
     */
    public function beans(): array
    {
        return [
            'eventManager' => [
                'class' => EventManager::class,
            ],
        ];
    }
}
