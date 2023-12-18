<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/20 0020
 * Time: 17:32
 */
declare(strict_types=1);

namespace validator;

/**
 *
 */
class EmailValidator extends BaseValidator
{

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     * 检查是否存在
     */
    public function trigger(string $field, mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

}
