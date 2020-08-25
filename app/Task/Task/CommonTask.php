<?php declare(strict_types = 1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Task\Task;

use App\Common\WsMessage;
use Swoft\Task\Annotation\Mapping\Task;
use Swoft\Task\Annotation\Mapping\TaskMapping;

/**
 * Class CommonTask
 *
 * @since 2.0
 *
 * @Task(name="common")
 */
class CommonTask
{
    /**
     * @TaskMapping(name="sendMessage")
     * @param array  $userList
     * @param string $cmd
     * @param array  $data
     */
    public function sendMessage(array $userList, string $cmd, array $data)
    {
        vdump($userList);
        vdump($cmd);
        vdump($data);
        if (!empty($userList)) {
            foreach ($userList as $value) {
                server()->sendTo($value, json_encode(['cmd' => $cmd, 'data' => $data]));
            }
        }
    }

}
