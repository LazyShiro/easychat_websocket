<?php
/**
 * @author gaobinzhan <gaobinzhan@gmail.com>
 */

namespace App\Model\Logic;

use App\Helper\MemoryTable;
use App\Model\Dao\FriendDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Task\Task;

/**
 * Class FriendLogic
 *
 * @package App\Model\Logic
 * @Bean()
 */
class FriendLogic
{
    /**
     * @Inject()
     * @var FriendDao
     */
    protected $friendModel;

}
