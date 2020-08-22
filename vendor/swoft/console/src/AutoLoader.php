<?php declare(strict_types=1);

namespace Swoft\Console;

use Swoft;
use Swoft\Console\Router\Router;
use Swoft\Helper\ComposerJSON;
use Swoft\SwoftComponent;
use function dirname;

/**
 * class AutoLoader
 *
 * @since 2.0
 */
final class AutoLoader extends SwoftComponent
{
    /**
     * Get namespace and dirs
     *
     * @return array
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

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
     * {@inheritDoc}
     */
    public function beans(): array
    {
        return [
            'cliApp'        => [
                'class'   => Application::class,
                'version' => Swoft::VERSION,
            ],
            'cliRouter'     => [
                'class' => Router::class,
            ],
            'cliDispatcher' => [
                'class' => ConsoleDispatcher::class,
            ],
        ];
    }
}
