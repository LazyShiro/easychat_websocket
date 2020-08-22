<?php declare(strict_types=1);

namespace SwoftTest\Serialize;

use PHPUnit\Framework\TestCase;
use Swoft\Serialize\PhpSerializer;

/**
 * Class PhpSerializerTest
 */
class PhpSerializerTest extends TestCase
{
    public function testUnserialize(): void
    {
        $serializer = new PhpSerializer();

        $str = 'a:1:{s:4:"name";s:5:"value";}';
        $ret = $serializer->unserialize($str);

        $this->assertIsArray($ret);
        $this->assertArrayHasKey('name', $ret);
    }

    public function testSerialize(): void
    {
        $serializer = new PhpSerializer();

        $arr = [
            'name' => 'value',
        ];
        $str = $serializer->serialize($arr);

        $this->assertIsString('string', $str);
        $this->assertStringStartsWith('a:1:{', $str);
    }
}
