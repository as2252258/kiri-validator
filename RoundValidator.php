<?php


namespace validator;


use Exception;

/**
 * Class RoundValidator
 * @package validator
 */
class RoundValidator extends BaseValidator
{

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     * @throws
     */
    public function trigger(string $field, mixed $value): bool
    {
        return round($value, $this->value) == $value;
    }


}
