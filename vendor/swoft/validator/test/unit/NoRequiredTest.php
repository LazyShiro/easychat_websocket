<?php declare(strict_types=1);

namespace SwoftTest\Validator\Unit;

use Swoft\Validator\Exception\ValidatorException;
use Swoft\Validator\Validator;
use SwoftTest\Validator\Testing\ValidatorNoRequired;

class NoRequiredTest extends TestCase
{
    public function testNoRequiredType()
    {
        $data = [];
        try {
            [$result] = (new Validator())->validateRequest($data,
                $this->getValidates(ValidatorNoRequired::class, 'testNoRequired'));
        } catch (ValidatorException $e) {
        }
        
        $this->assertEmpty($result);
        $this->assertIsArray($result);
        $this->assertEquals($data, $result);
    }
}
