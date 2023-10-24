<?php

declare(strict_types=1);

namespace validator;


/**
 * Class EnumValidator
 * @package validator
 */
class EnumValidator extends BaseValidator
{

    public array $value = [];

    /**
     * @return bool
     */
    public function trigger(): bool
    {
        return $this->_validator($this->field, function ($field, $params, $values) {
            $value = $params[$field] ?? null;
            if (in_array($value, $values)) {
                return true;
            }
            $message = 'The param :attribute value(' . $value . ') only in ' . implode(',', $values);
            return $this->addError($field, $message);

        }, $this->params, $this->value);
    }

}
