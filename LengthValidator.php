<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 17:04
 */
declare(strict_types=1);

namespace validator;


class LengthValidator extends BaseValidator
{

    const string MAX_LENGTH = 'max';
    const string MIN_LENGTH = 'min';

    public string $method;

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    public function trigger(string $field, mixed $value): bool
    {
        return match ($this->method) {
            self::MAX_LENGTH => $this->maxLength((string)$value),
            self::MIN_LENGTH => $this->minLength((string)$value),
            default          => $this->defaultLength((string)$value),
        };
    }

    /**
     * @param string $value
     * @return bool
     *
     * 效验长度是否大于最大长度
     */
    private function maxLength(string $value): bool
    {
        return mb_strlen($value) <= $this->value;
    }

    /**
     * @param string $value
     * @return bool
     *
     * 效验长度是否小于最小长度
     */
    private function minLength(string $value): bool
    {
        return mb_strlen($value) >= $this->value;
    }

    /**
     * @param string $value
     * @return bool
     *
     * 效验长度是否小于最小长度
     */
    private function defaultLength(string $value): bool
    {
        return mb_strlen($value) == $this->value;
    }
}
