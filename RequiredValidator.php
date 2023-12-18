<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:47
 */
declare(strict_types=1);

namespace validator;


class RequiredValidator extends BaseValidator
{

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     * 检查是否存在
     */
    public function trigger(string $field, mixed $value): bool
    {
        return !is_null($value);
    }

}
