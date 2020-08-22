<?php

namespace Swoft\Http\Server\Listener;

use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Http\Server\Exception\HttpServerException;
use Swoft\Http\Server\Middleware\MiddlewareRegister;
use Swoft\Http\Server\Router\Router;
use Swoft\Http\Server\Router\RouteRegister;
use Swoft\SwoftEvent;
use function bean;

/**
 * Class AppInitCompleteListener
 * @since 2.0
 *
 * @Listener(SwoftEvent::APP_INIT_COMPLETE)
 */
class AppInitCompleteListener implements EventHandlerInterface
{
    /**
     * @param EventInterface $event
     *
     * @throws HttpServerException
     */
    public function handle(EventInterface $event): void
    {
        /** @var Router $router Register HTTP routes */
        $router = bean('httpRouter');

        RouteRegister::registerRoutes($router);

        // Register middleware
        MiddlewareRegister::register();
    }
}
