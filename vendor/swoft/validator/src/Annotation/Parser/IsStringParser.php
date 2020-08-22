<?php declare(strict_types=1);


namespace Swoft\Validator\Annotation\Parser;

use ReflectionException;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Exception\ValidatorException;
use Swoft\Validator\ValidatorRegister;

/**
 * Class IsStringParser
 *
 * @since 2.0
 *
 * @AnnotationParser(IsString::class)
 */
class IsStringParser extends Parser
{
    /**
     * @param int    $type
     * @param object $annotationObject
     *
     * @return array
     * @throws ValidatorException
     * @throws ReflectionException
     */
    public function parse(int $type, $annotationObject): array
    {
        if ($type != self::TYPE_PROPERTY) {
            return [];
        }

        ValidatorRegister::registerValidatorItem($this->className, $this->propertyName, $annotationObject);

        return [];
    }
}
