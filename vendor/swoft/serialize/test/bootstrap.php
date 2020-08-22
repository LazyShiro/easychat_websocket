<?php
/**
 * phpunit
 */

error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set('Asia/Shanghai');

spl_autoload_register(function ($class) {
    $file = null;

    if (0 === strpos($class, 'Swoft\Serialize\Example\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('Swoft\Serialize\Example\\')));
        $file = dirname(__DIR__) . "/example/{$path}.php";
    } elseif (0 === strpos($class, 'Swoft\Serialize\Test\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('Swoft\Serialize\Test\\')));
        $file = __DIR__ . "/unit/{$path}.php";
    } elseif (0 === strpos($class, 'Swoft\Serialize\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('Swoft\Serialize\\')));
        $file = dirname(__DIR__) . "/src/{$path}.php";
    }

    if ($file && is_file($file)) {
        include $file;
    }
});
