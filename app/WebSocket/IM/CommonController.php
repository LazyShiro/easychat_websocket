<?php declare(strict_types = 1);

namespace App\WebSocket\IM;

use Swoft\WebSocket\Server\Annotation\Mapping\MessageMapping;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;

/**
 * Class CommonController
 * @WsController("common")
 */
class CommonController
{
    /**
     * @MessageMapping("connect")
     */
    public function connect()
    {
        return wsReturn(100000);
    }

}
