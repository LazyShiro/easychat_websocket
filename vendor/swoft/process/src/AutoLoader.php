<?php declare(strict_types=1);

namespace Swoft\Process;

use Swoft\Helper\ComposerJSON;
use Swoft\Process\Swoole\WorkerStartListener;
use Swoft\Process\Swoole\WorkerStopListener;
use Swoft\SwoftComponent;

/**
 * Class AutoLoader
 *
 * @since 2.0
 */
class AutoLoader extends SwoftComponent
{
    /**
     * @return array
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
            'processPool' => [
                'class' => ProcessPool::class,
                'on'    => [
                    SwooleEvent::WORKER_START => bean(WorkerStartListener::class),
                    SwooleEvent::WORKER_STOP  => bean(WorkerStopListener::class)
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        $jsonFile = dirname(__DIR__) . '/composer.json';

        return ComposerJSON::open($jsonFile)->getMetadata();
    }
}
