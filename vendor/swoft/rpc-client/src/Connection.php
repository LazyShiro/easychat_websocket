<?php declare(strict_types=1);

namespace Swoft\Rpc\Client;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Concern\PrototypeTrait;
use Swoft\Connection\Pool\AbstractConnection;
use Swoft\Log\Debug;
use Swoft\Rpc\Client\Client as RpcClient;
use Swoft\Rpc\Client\Contract\ConnectionInterface;
use Swoft\Rpc\Client\Exception\RpcClientException;
use Swoft\Rpc\Contract\PacketInterface;
use Swoft\Stdlib\Helper\JsonHelper;
use Swoole\Coroutine\Client;
use function array_rand;
use function count;
use function explode;
use function is_array;
use function sprintf;

/**
 * Class Connection
 *
 * @since 2.0
 *
 * @Bean(scope=Bean::PROTOTYPE)
 */
class Connection extends AbstractConnection implements ConnectionInterface
{
    use PrototypeTrait;

    /**
     * @var Client
     */
    protected $connection;

    /**
     * @var RpcClient
     */
    protected $client;

    /**
     * @param \Swoft\Rpc\Client\Client $client
     * @param Pool                     $pool
     *
     * @return Connection
     */
    public static function new(RpcClient $client, Pool $pool): Connection
    {
        $instance = self::__instance();

        $instance->client = $client;
        $instance->pool   = $pool;

        $instance->lastTime = time();

        return $instance;
    }

    /**
     * @throws RpcClientException
     */
    public function create(): void
    {
        $connection = new Client(SWOOLE_SOCK_TCP);
        [$host, $port] = $this->getHostPort();

        $setting = $this->client->getSetting();
        if ($setting) {
            $connection->set($setting);
        }

        if (!$connection->connect($host, (int)$port)) {
            throw new RpcClientException(sprintf('Connect failed host=%s port=%d', $host, $port));
        }

        $this->connection = $connection;
    }

    /**
     * Close connection
     */
    public function close(): void
    {
        $this->connection->close();
    }

    /**
     * @return bool
     * @throws RpcClientException
     */
    public function reconnect(): bool
    {
        $this->create();

        Debug::log('Rpc client reconnect success!');
        return true;
    }

    /**
     * @return PacketInterface
     * @throws RpcClientException
     */
    public function getPacket(): PacketInterface
    {
        return $this->client->getPacket();
    }

    /**
     * @return \Swoft\Rpc\Client\Client
     */
    public function getClient(): \Swoft\Rpc\Client\Client
    {
        return $this->client;
    }

    /**
     * @param string $data
     *
     * @return bool
     */
    public function send(string $data): bool
    {
        return (bool)$this->connection->send($data);
    }

    /**
     * @return string|bool
     */
    public function recv()
    {
        // fix: The timeout setting uses the configuration when the client connects. timeout, read_timeout
        return $this->connection->recv();
    }

    /**
     * @return array
     * @throws RpcClientException
     */
    private function getHostPort(): array
    {
        $provider = $this->client->getProvider();
        if (!$provider) {
            return [$this->client->getHost(), $this->client->getPort()];
        }

        $list = $provider->getList($this->client);
        if (!$list) {
            throw new RpcClientException(sprintf('Provider return list can not empty!'));
        }

        if (!is_array($list)) {
            throw new RpcClientException(sprintf('Provider(%s) return format is error!', JsonHelper::encode($list)));
        }

        $randKey  = array_rand($list, 1);
        $hostPort = explode(':', $list[$randKey]);

        if (count($hostPort) < 2) {
            throw new RpcClientException(sprintf('Provider(%s) return format is error!', $list[$randKey]));
        }

        [$host, $port] = $hostPort;
        return [$host, $port];
    }
}
