<?php declare(strict_types=1);

namespace Swoft\Crontab\Listener;

use Swoft;
use Swoft\Crontab\CrontabEvent;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\SwoftEvent;

/**
 * Class AfterCrontabListener
 *
 * @since 2.0
 *
 * @Listener(event=CrontabEvent::AFTER_CRONTAB)
 */
class AfterCrontabListener implements EventHandlerInterface
{
    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        // Defer
        Swoft::trigger(SwoftEvent::COROUTINE_DEFER);

        // Destroy
        Swoft::trigger(SwoftEvent::COROUTINE_COMPLETE);
    }
}
