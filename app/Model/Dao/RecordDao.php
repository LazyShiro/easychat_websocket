<?php

namespace App\Model\Dao;

use App\Model\Entity\ChatRecord;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class RecordDao
 *
 * @package App\Model\Dao
 * @Bean()
 */
class RecordDao
{
    /**
     * @Inject()
     * @var ChatRecord
     */
    protected $recordModel;

    /**
     * 新增消息
     *
     * @param int    $roomId
     * @param int    $uid
     * @param string $content
     * @param int    $time
     *
     * @return string
     */
    public function addDataByPrivateChat(int $roomId, int $uid, string $content, int $time)
    {
        return $this->recordModel->insertGetId(['roomid' => $roomId, 'uid' => $uid, 'content' => $content, 'status' => 1, 'createtime' => $time]);
    }

}
