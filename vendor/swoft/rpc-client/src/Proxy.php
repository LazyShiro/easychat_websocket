<?php declare(strict_types=1);

namespace Swoft\Rpc\Client;

use Swoft\Proxy\Exception\ProxyException;
use Swoft\Proxy\Proxy as BaseProxy;
use Swoft\Rpc\Client\Exception\RpcClientException;
use Swoft\Rpc\Client\Proxy\Ast\ProxyVisitor;
use Swoft\Stdlib\Helper\Str;
use function interface_exists;
use function sprintf;

/**
 * Class Proxy
 *
 * @since 2.0
 */
class Proxy
{
    /**
     * @param string $className
     *
     * @return string
     * @throws RpcClientException
     * @throws ProxyException
     */
    public static function newClassName(string $className): string
    {
        if (!interface_exists($className)) {
            throw new RpcClientException('`@var` for `@Reference` must be exist interface!');
        }

        $proxyId = sprintf('IGNORE_%s', Str::getUniqid());
        $visitor = new ProxyVisitor($proxyId);

        return BaseProxy::newClassName($className, $visitor);
    }
}
