<?php declare(strict_types=1);

namespace Swoft\Proxy;

use Swoft\Proxy\Ast\Parser;
use Swoft\Proxy\Ast\Visitor\Visitor;
use Swoft\Proxy\Exception\ProxyException;
use Swoft\Stdlib\Helper\Sys;
use function file_put_contents;
use function sprintf;
use const PHP_EOL;

/**
 * Class Proxy
 *
 * @package Swoft\Proxy
 */
class Proxy
{
    /**
     * Optimize logic
     * - Save classes that have been parsed and generated to avoid repeated parsing and loading
     *
     * @var array
     */
    private static $caches = [];

    /**
     * New class name by proxy
     *
     * @param string  $className
     * @param Visitor $visitor
     *
     * @return string
     * @throws ProxyException
     */
    public static function newClassName(string $className, Visitor $visitor): string
    {
        if (isset(self::$caches[$className])) {
            return self::$caches[$className];
        }

        $parser = new Parser();
        $parser->addNodeVisitor(get_class($visitor), $visitor);

        $proxyCode = $parser->parse($className);
        $proxyName = $visitor->getProxyName();
        // New proxy class name
        $newClassName = $visitor->getProxyClassName();

        // Proxy file and proxy code
        $proxyFile = sprintf('%s/%s.php', Sys::getTempDir(), $proxyName);
        $proxyCode = sprintf('<?php %s %s', PHP_EOL, $proxyCode);

        // Generate proxy class
        $result = file_put_contents($proxyFile, $proxyCode);
        if ($result === false) {
            throw new ProxyException(sprintf('Proxy file(%s) generate fail', $proxyFile));
        }

        // Load new proxy class file.
        self::loadProxyClass($proxyFile);

        // Ensure proxy class is loaded
        if (!class_exists($newClassName)) {
            throw new ProxyException(sprintf('Proxy class(%s) is not exist!', $newClassName));
        }

        // Add cache, mark has been required.
        self::$caches[$className] = $newClassName;
        return $newClassName;
    }

    /**
     * @param string $proxyFile
     */
    private static function loadProxyClass(string $proxyFile): void
    {
        /** @noinspection PhpIncludeInspection */
        require $proxyFile;

        // Remove proxy file
        unlink($proxyFile);
    }
}
