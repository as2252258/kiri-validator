<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:28
 */
declare(strict_types=1);

namespace validator;


/**
 * Class ArrayValidator
 * @package validator
 */
class ArrayValidator extends BaseValidator
{

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     *
     * 检查
     */
    public function trigger(string $field, mixed $value): bool
    {
        return is_array($value);
    }

}
