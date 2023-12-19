<?php

declare(strict_types=1);

namespace validator;


/**
 * Class EnumValidator
 * @package validator
 */
class EnumValidator extends BaseValidator
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function trigger(mixed $value): bool
    {
        return in_array($value, $this->value);
    }

}
