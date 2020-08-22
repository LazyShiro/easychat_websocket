<?php declare(strict_types=1);


namespace Swoft\Db\Listener;


use function bean;
use Swoft\Db\Connection\ConnectionManager;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\SwoftEvent;

/**
 * Class CoroutineDestroyListener
 *
 * @since 2.0
 *
 * @Listener(SwoftEvent::COROUTINE_DESTROY)
 */
class CoroutineDestroyListener implements EventHandlerInterface
{
    /**
     * @param EventInterface $event
     *
     */
    public function handle(EventInterface $event): void
    {
        /* @var ConnectionManager $cm */
        $cm = bean(ConnectionManager::class);
        $cm->release(true);
    }
}
