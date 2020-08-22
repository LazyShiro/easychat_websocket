<?php declare(strict_types=1);

namespace Swoft\Server\Swoole;

use Swoft;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Log\Helper\CLog;
use Swoft\Server\Contract\PipeMessageInterface;
use Swoft\Server\ServerEvent;
use Swoole\Server;

/**
 * Class PipeMessageListener
 *
 * @since 2.0.7
 * @Bean()
 */
class PipeMessageListener implements PipeMessageInterface
{
    /**
     * Pipe message event handle
     *
     * @param Server $server
     * @param int    $srcWorkerId
     * @param mixed  $message
     */
    public function onPipeMessage(Server $server, int $srcWorkerId, $message): void
    {
        CLog::debug("PipeMessage: received pipe-message fromWID=$srcWorkerId message=$message");

        Swoft::trigger(ServerEvent::PIPE_MESSAGE, $message, $srcWorkerId, $server);
    }
}
