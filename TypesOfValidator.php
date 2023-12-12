<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/4 0004
 * Time: 18:44
 */
declare(strict_types=1);

namespace validator;


class TypesOfValidator extends BaseValidator
{


    const string JSON  = 'json';
    const string FLOAT = 'float';
    const string ARRAY  = 'array';
    const string STRING  = 'string';
    const string INTEGER = 'integer';

    private ?int $min = null;
    private ?int $max = null;

    /** @var array */
    public array $types = [
        self::JSON    => 'json',
        self::FLOAT   => 'float',
        self::ARRAY   => 'array',
        self::STRING  => 'string',
        self::INTEGER => 'integer'
    ];

    /** @var string */
    public string $method;


    /**
     * @return bool
     */
    public function trigger(): bool
    {
        return $this->_validator($this->field, function ($field, $params, $method, $types) {
            if (!in_array($method, $types)) {
                return true;
            }
            $value = $params[$field] ?? null;
            return match ($method) {
                self::INTEGER => $this->integerFormat($field, $value),
                self::FLOAT => $this->floatFormat($field, $value),
                self::JSON => $this->jsonFormat($field, $value),
                self::STRING => $this->stringFormat($field, $value),
                self::ARRAY => $this->arrayFormat($field, $value),
            };
        }, $this->params, $this->method, $this->types);
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    public function jsonFormat($field, $value): bool
    {
        if (!is_string($value) || is_null(json_decode($value))) {
            return $this->addError($field, 'The ' . $field . ' not is JSON data.');
        }
        return true;
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    public function arrayFormat($field, $value): bool
    {
        if (!is_array($value)) {
            return $this->addError($field, 'The ' . $field . ' not is array data.');
        }
        return true;
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    public function stringFormat($field, $value): bool
    {
        if (!is_string($value)) {
            return $this->addError($field, 'The ' . $field . ' not is string data.');
        }
        return true;
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    public function integerFormat($field, $value): bool
    {
        if ((int)$value != $value) {
            return $this->addError($field, 'The ' . $field . ' not is number data.');
        }
        return true;
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    public function floatFormat($field, $value): bool
    {
        $trim = (float)$value;
        if ($trim != $value) {
            return $this->addError($field, 'The ' . $field . ' not is float data.');
        }
        return true;
    }

}
