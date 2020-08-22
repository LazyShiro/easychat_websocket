# Data Serialize

[![Latest Stable Version](http://img.shields.io/packagist/v/swoft/serialize.svg)](https://packagist.org/packages/swoft/serialize)
[![Php Version](https://img.shields.io/badge/php-%3E=7.1-brightgreen.svg?maxAge=2592000)](https://secure.php.net/)
[![Library License](https://img.shields.io/hexpm/l/plug.svg?maxAge=2592000)](https://github.com/swoft-cloud/swoft-serialize/blob/master/LICENSE)

Universal data serializer for PHP

Serializers:

- json(by `json_encode`)
- php(by `serialize`)
- igbinary(by extension `igbinary`)
- msgpack(by extension `msgpack`)

## Install

- composer command

```bash
composer require swoft/serialize
```

## Usage

```php
$serializer = new JsonSerializer();
// $serializer = new PhpSerializer();
// $serializer = new IgBinarySerializer();
// $serializer = new MsgPackSerializer();

// serialize data
$string = $serializer->serialize($data);

// unserialize string
$data = $serializer->unserialize($string);
```

## Unit testing

```bash
phpunit 
```

## LICENSE

The Component is open-sourced software licensed under the [Apache license](LICENSE).

