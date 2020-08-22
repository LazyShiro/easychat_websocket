<?php declare(strict_types=1);

namespace Swoft\Processor;

use ReflectionException;
use Swoft\Console\CommandRegister;
use Swoft\Console\Router\Router;
use Swoft\Log\Helper\CLog;
use function bean;

/**
 * Console processor
 *
 * @since 2.0
 */
class ConsoleProcessor extends Processor
{
    /**
     * Handle console init
     *
     * @return bool
     * @throws ReflectionException
     */
    public function handle(): bool
    {
        if (!$this->application->beforeConsole()) {
            return false;
        }

        /** @var Router $router */
        $router = bean('cliRouter');

        // Register console routes
        CommandRegister::register($router);

        CLog::info('Console command route registered (group %d, command %d)', $router->groupCount(), $router->count());

        // Run console application
        if ($this->application->isStartConsole()) {
            bean('cliApp')->run();
        }

        return $this->application->afterConsole();
    }
}
