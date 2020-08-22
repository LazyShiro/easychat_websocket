<?php declare(strict_types=1);

namespace SwoftTest\Serialize;

use PHPUnit\Framework\TestCase;
use Swoft\Serialize\JsonSerializer;

/**
 * Class JsonSerializerTest
 */
class JsonSerializerTest extends TestCase
{
    public function testUnserialize(): void
    {
        $str = '{"name": "value"}';

        $serializer = new JsonSerializer();
        $ret        = $serializer->unserialize($str);

        $this->assertIsArray($ret);
        $this->assertArrayHasKey('name', $ret);
    }

    public function testSerialize(): void
    {
        $serializer = new JsonSerializer();

        $arr = [
            'name' => 'value',
        ];
        $str = $serializer->serialize($arr);

        $this->assertIsString($str);
        $this->assertJson($str);
    }
}
