<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/4 0004
 * Time: 18:44
 */
declare(strict_types=1);

namespace validator;


use function json_validate;

class TypesOfValidator extends BaseValidator
{


    const string JSON    = 'json';
    const string FLOAT   = 'float';
    const string ARRAY   = 'array';
    const string STRING  = 'string';
    const string INTEGER = 'integer';

    /** @var string */
    public string $method;

    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    public function trigger(mixed $value): bool
    {
        return match ($this->method) {
            self::INTEGER => $this->integerFormat($value),
            self::FLOAT   => $this->floatFormat($value),
            self::JSON    => $this->jsonFormat($value),
            self::STRING  => $this->stringFormat($value),
            self::ARRAY   => $this->arrayFormat($value),
        };
    }

    /**
     * @param string|null $value
     * @return bool
     */
    public function jsonFormat(?string $value): bool
    {
        return json_validate($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function arrayFormat(mixed $value): bool
    {
        return is_array($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function stringFormat(mixed $value): bool
    {
        return is_string($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function integerFormat(mixed $value): bool
    {
        return (int)$value == $value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function floatFormat(mixed $value): bool
    {
        return (float)$value == $value;
    }

}
