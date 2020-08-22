<?php declare(strict_types=1);

namespace Swoft\Rpc\Server;

use Swoft;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\BeanFactory;
use Swoft\Concern\AbstractDispatcher;
use Swoft\Rpc\Server\Middleware\DefaultMiddleware;
use Swoft\Rpc\Server\Middleware\UserMiddleware;
use Throwable;

/**
 * Class ServiceDispatcher
 *
 * @since 2.0
 *
 * @Bean(name="serviceDispatcher")
 */
class ServiceDispatcher extends AbstractDispatcher
{
    /**
     * @var string
     */
    protected $defaultMiddleware = DefaultMiddleware::class;

    /**
     * @param array $params
     *
     */
    public function dispatch(...$params)
    {
        /**
         * @var Request  $request
         * @var Response $response
         */
        [$request, $response] = $params;

        try {
            Swoft::trigger(ServiceServerEvent::BEFORE_RECEIVE, null, $request, $response);

            $handler  = ServiceHandler::new($this->requestMiddleware(), $this->defaultMiddleware);
            $response = $handler->handle($request);
        } catch (Throwable $e) {
            /** @var RpcErrorDispatcher $errDispatcher */
            $errDispatcher = BeanFactory::getSingleton(RpcErrorDispatcher::class);

            // Handle request error
            $response = $errDispatcher->run($e, $response);
        }

        Swoft::trigger(ServiceServerEvent::AFTER_RECEIVE, null, $response);
    }

    /**
     * @return array
     */
    public function preMiddleware(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function afterMiddleware(): array
    {
        return [
            UserMiddleware::class
        ];
    }
}
