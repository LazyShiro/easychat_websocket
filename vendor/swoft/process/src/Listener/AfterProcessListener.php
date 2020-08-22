<?php declare(strict_types=1);

namespace Swoft\Process\Listener;

use Swoft;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Process\ProcessEvent;
use Swoft\SwoftEvent;

/**
 * Class AfterProcessListener
 *
 * @since 2.0
 *
 * @Listener(event=ProcessEvent::AFTER_PROCESS_START)
 */
class AfterProcessListener implements EventHandlerInterface
{
    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        // var_dump('AfterProcessListener');

        // Defer
        Swoft::trigger(SwoftEvent::COROUTINE_DEFER);

        // Destroy
        Swoft::trigger(SwoftEvent::COROUTINE_COMPLETE);
    }
}
