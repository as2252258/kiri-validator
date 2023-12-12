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
     * @return bool
     */
    public function trigger(): bool
    {
        return $this->_validator($this->field, function ($field, $params, $method) {
            $value = $params[$field] ?? null;
            return match ($method) {
                self::DATE        => $this->validatorDate($field, $value),
                self::DATE_TIME   => $this->validateDatetime($field, $value),
                self::TIME        => $this->validatorTime($field, $value),
                self::STR_TO_TIME => $this->validatorTimestamp($field, $value),
                default           => true,
            };
        }, $this->params, strtolower($this->method));


    }

    /**
     * @param $field
     * @param $value
     * @return bool
     *
     * 效验分秒 格式如  01:02 or 01-02
     */
    public function validatorTime($field, $value): bool
    {
        if (!is_string($value)) {
            return $this->addError($field, 'The param :attribute not is a date value');
        }
        $match = preg_match('/^[0-5]?\d{1}.{1}[0-5]?\d{1}$/', $value, $result);
        if ($match && $result[0] == $value) {
            return true;
        } else {
            return $this->addError($field, 'The param :attribute format error');
        }
    }


    /**
     * @param $field
     * @param $value
     * @return bool
     *
     * 效验分秒 格式如 2017-12-22 01:02
     */
    public function validateDatetime($field, $value): bool
    {
        if (!is_string($value)) {
            return $this->addError($field, 'The param :attribute not is a date value');
        }
        $match = '/^\d{4}\-\d{2}\-\d{2}\s+\d{2}:\d{2}:\d{2}$/';
        $match = preg_match($match, $value, $result);
        if ($match && $result[0] == $value) {
            return true;
        } else {
            return $this->addError($field, 'The param :attribute format error');
        }
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     *
     * 效验分秒 格式如  2017-12-22
     */
    public function validatorDate($field, $value): bool
    {
        if (!is_string($value)) {
            return $this->addError($field, 'The param :attribute not is a date value');
        }
        $match = preg_match('/^(\d{4}).*([0-12]).*([0-31]).*$/', $value, $result);
        if ($match && $result[0] == $value) {
            return true;
        } else {
            return $this->addError($field, 'The param :attribute format error');
        }
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     *
     * 效验时间戳 格式如  1521452254
     */
    public function validatorTimestamp($field, $value): bool
    {
        if (!is_numeric($value)) {
            return $this->addError($field, 'The param :attribute not is a timestamp value');
        }
        if (strlen((string)$value) != 10) {
            return $this->addError($field, 'The param :attribute not is a timestamp value');
        }
        if (!date('YmdHis', $value)) {
            return $this->addError($field, 'The param :attribute format error');
        }
        return true;
    }
}
