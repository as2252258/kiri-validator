<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/4 0004
 * Time: 18:44
 */
declare(strict_types=1);

namespace validator;


use Database\ModelInterface;

/**
 *
 */
class IntegerValidator extends BaseValidator
{

    /**
     * @param string $field
     * @param float $value
     * @return bool
     */
    public function trigger(string $field, mixed $value): bool
    {
        return (float)$value == $value;
    }
}
