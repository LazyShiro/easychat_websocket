<?php declare(strict_types=1);


namespace Swoft\Validator\Rule;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Validator\Annotation\Mapping\IsFloat;
use Swoft\Validator\Contract\RuleInterface;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class IsFloatRule
 *
 * @since 2.0
 *
 * @Bean(IsFloat::class)
 */
class IsFloatRule implements RuleInterface
{
    /**
     * @param array      $data
     * @param string     $propertyName
     * @param object     $item
     * @param mixed|null $default
     *
     * @return array
     * @throws ValidatorException
     */
    public function validate(array $data, string $propertyName, $item, $default = null, $strict = false): array
    {
        /* @var IsFloat $item */
        $message = $item->getMessage();

        if (!isset($data[$propertyName]) && $default !== null) {
            $data[$propertyName] = (float)$default;
            return $data;
        }

        if (!isset($data[$propertyName]) && $default === null) {
            $message = (empty($message)) ? sprintf('%s must exist!', $propertyName) : $message;
            throw new ValidatorException($message);
        }

        $value = $data[$propertyName];
        if ($strict) {
            if (is_float($value)) {
                $data[$propertyName] = (float)$value;
                return $data;
            }
        } else {
            $value = filter_var($value, FILTER_VALIDATE_FLOAT);
            if ($value !== false) {
                $data[$propertyName] = $value;
                return $data;
            }
        }

        $message = (empty($message)) ? sprintf('%s must float!', $propertyName) : $message;
        throw new ValidatorException($message);
    }
}
