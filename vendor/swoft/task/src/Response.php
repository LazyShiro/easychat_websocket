<?php declare(strict_types=1);


namespace Swoft\Task;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Concern\PrototypeTrait;
use Swoft\Task\Contract\ResponseInterface;
use Swoole\Server\Task as SwooleTask;

/**
 * Class Response
 *
 * @since 2.0
 *
 * @Bean(scope=Bean::PROTOTYPE)
 */
class Response implements ResponseInterface
{
    use PrototypeTrait;

    /**
     * @var SwooleTask
     */
    private $task;

    /**
     * @var mixed
     */
    private $result;

    /**
     * @var int|null
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorMessage = '';

    /**
     * @param SwooleTask $task
     *
     * @return Response
     */
    public static function new(SwooleTask $task): self
    {
        $instance = self::__instance();

        $instance->task = $task;

        return $instance;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }

    /**
     * @param int|null $errorCode
     */
    public function setErrorCode(?int $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getResponseData(): string
    {
        return Packet::packResponse($this->result, $this->errorCode, $this->errorMessage);
    }

    /**
     * Send task
     */
    public function send(): void
    {
        $this->task->finish($this->getResponseData());
    }
}