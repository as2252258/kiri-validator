<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:46
 */

declare(strict_types=1);


namespace validator;


/**
 *
 */
class EmptyValidator extends BaseValidator
{

    /** @var string [不能为空] */
    const string CAN_NOT_EMPTY = 'not empty';

    /** @var string [可为空, 不能为null] */
    const string CAN_NOT_NULL = 'not null';

    public string $method;

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     *
     * 检查参数是否为NULL
     */
    public function trigger(string $field, mixed $value): bool
    {
        return match ($this->method) {
            self::CAN_NOT_NULL  => !is_null($value),
            self::CAN_NOT_EMPTY => !empty($value),
            default             => true
        };
    }
}
