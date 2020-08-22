<?php declare(strict_types=1);

namespace Swoft\Console;

use Swoft;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Console\Input\Input;
use Swoft\Console\Output\Output;
use Swoft\Context\AbstractContext;
use Throwable;
use function bean;
use function uniqid;

/**
 * Class ConsoleContext
 *
 * @since 2.0
 * @Bean(scope=Bean::PROTOTYPE)
 */
class ConsoleContext extends AbstractContext
{
    /**
     * @return ConsoleContext
     * @throws Throwable
     */
    public static function new(): self
    {
        /** @var self $ctx */
        $ctx = bean(static::class);

        $ctx->setMulti([
            'parentid' => '',
            'spanid'   => uniqid('', false),
            'traceid'  => uniqid('', false),
        ]);

        return $ctx;
    }

    /**
     * @return Input
     * @throws Throwable
     */
    public function getInput(): Input
    {
        return Swoft::getSingleton('input');
    }

    /**
     * @return Output
     * @throws Throwable
     */
    public function getOutput(): Output
    {
        return Swoft::getSingleton('output');
    }
}
