<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:42
 */
declare(strict_types=1);

namespace validator;


class DateTimeValidator extends BaseValidator
{

    const string DATE        = 'date';
    const string DATE_TIME   = 'datetime';
    const string TIME        = 'time';
    const string STR_TO_TIME = 'timestamp';

    public string $method;

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    public function trigger(string $field, mixed $value): bool
    {
        $value = $params[$field] ?? null;
        return match ($this->method) {
            self::DATE        => $this->validatorDate($value),
            self::DATE_TIME   => $this->validateDatetime($value),
            self::TIME        => $this->validatorTime($value),
            self::STR_TO_TIME => $this->validatorTimestamp($value),
            default           => true,
        };
    }

    /**
     * @param string $value
     * @return bool
     *
     * 效验分秒 格式如  01:02 or 01-02
     */
    public function validatorTime(string $value): bool
    {
        return (bool)preg_match('/^\d{2}:\d{2}(:\d{2})?+(\.\d+)?$/', $value);
    }


    /**
     * @param string $value
     * @return bool
     *
     * 效验分秒 格式如 2017-12-22 01:02
     */
    public function validateDatetime(string $value): bool
    {
        return (bool)preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}(:\d{2})?+(\.\d+)?$/', $value);
    }

    /**
     * @param string $value
     * @return bool
     *
     * 效验分秒 格式如  2017-12-22
     */
    public function validatorDate(string $value): bool
    {
        return (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $value);
    }

    /**
     * @param string|int $value
     * @return bool
     *
     * 效验时间戳 格式如  1521452254
     */
    public function validatorTimestamp(string|int $value): bool
    {
        return (bool)preg_match('/^1\d{9}$/', $value);
    }
}
