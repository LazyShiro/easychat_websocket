<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace SwoftTest\WebSocket\Server\Testing;

use Swoft\Stdlib\Helper\Arr;
use Swoole\Http\Request;

/**
 * Class MockHttpRequest
 *
 * @since 2.0
 */
class MockHttpRequest extends Request
{
    public const GET    = 'GET';

    public const PUT    = 'PUT';

    public const POST   = 'POST';

    public const DELETE = 'DELETE';

    /**
     * @var int
     */
    public $fd = 1;

    /**
     * @var int
     */
    public $streamId = 1;

    /**
     * @var array
     */
    public $header = [];

    /**
     * @var array
     */
    public $server = [];

    /**
     * @var array
     */
    public $request = [];

    /**
     * @var array
     */
    public $cookie = [];

    /**
     * @var array
     */
    public $get = [];

    /**
     * @var array
     */
    public $files = [];

    /**
     * @var array
     */
    public $post = [];

    /**
     * @var array
     */
    public $tmpfiles = [];

    /**
     * @var string
     */
    public $content = '';

    /**
     * @param array $server
     * @param array $headers
     * @param array $cookies
     * @param array $params
     *
     * @return self
     */
    public static function new(array $server = [], array $headers = [], array $cookies = [], array $params = []): self
    {
        $instance = new self;

        $instance->cookie = $cookies;
        $instance->header = Arr::merge(self::defaultHeaders(), $headers);
        $instance->server = Arr::merge(self::defaultServers(), $server);

        $method = $instance->server['request_method'];

        if ($method === self::GET) {
            $instance->get = $params;
        } elseif ($method === self::POST) {
            $instance->post = $params;
        }

        return $instance;
    }

    /**
     * @return string
     */
    public function rawContent(): string
    {
        return $this->content;
    }

    /**
     * @param mixed $fd
     */
    public function setFd($fd): void
    {
        $this->fd = $fd;
    }

    /**
     * @param mixed $streamId
     */
    public function setStreamId($streamId): void
    {
        $this->streamId = $streamId;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header): void
    {
        $this->header = $header;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server): void
    {
        $this->server = $server;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request): void
    {
        $this->request = $request;
    }

    /**
     * @param mixed $cookie
     */
    public function setCookie($cookie): void
    {
        $this->cookie = $cookie;
    }

    /**
     * @param mixed $get
     */
    public function setGet($get): void
    {
        $this->get = $get;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files): void
    {
        $this->files = $files;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }

    /**
     * @param mixed $tmpfiles
     */
    public function setTmpfiles($tmpfiles): void
    {
        $this->tmpfiles = $tmpfiles;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public static function defaultHeaders(): array
    {
        return [
            'user-agent' => 'curl/7.29.0',
            'host'       => '127.0.0.1:18308',
            'accept'     => '*/*',
        ];
    }

    /**
     * @return array
     */
    public static function defaultServers(): array
    {
        return [
            'request_method'     => 'GET',
            'request_uri'        => '/',
            'request_query'      => '',
            'request_time'       => time(),
            'request_time_float' => microtime(true),
            'server_port'        => 18306,
            'remote_port'        => 56984,
            'remote_addr'        => '127.0.0.1',
            'master_time'        => 1555679772,
            'server_protocol'    => 'HTTP/1.1',
        ];
    }
}
