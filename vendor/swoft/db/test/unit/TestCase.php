<?php declare(strict_types=1);

namespace SwoftTest\Db\Unit;

use Swoft\Db\Exception\DbException;
use Swoft\Stdlib\Helper\Str;
use SwoftTest\Db\Testing\Entity\Count;
use SwoftTest\Db\Testing\Entity\User;

/**
 * Class TestCase
 *
 * @since 2.0
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return int
     * @throws DbException
     */
    public function addRecord(): int
    {
        /* @var User $user */
        $user = User::new();
        $user->setAge(mt_rand(1, 100));
        $user->setUserDesc('desc');

        // Save result
        $result = $user->save();
        $this->assertTrue($result);

        return $user->getId();
    }

    /**
     * @param null $userId
     *
     * @return null|int
     * @throws DbException
     */
    public function addCountRecord($userId = null)
    {
        $count = Count::new();
        $count->setUserId($userId ?: $this->addRecord());
        $count->setCreateTime(time());
        $count->setAttributes(Str::random());
        // Save result
        $result = $count->save();
        $this->assertTrue($result);

        return $count->getId();
    }
}
