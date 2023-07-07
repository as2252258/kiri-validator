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


	const JSON = 'json';
	const FLOAT = 'float';
	const ARRAY = 'array';
	const STRING = 'string';
	const INTEGER = 'integer';
	const SERIALIZE = 'serialize';

	private ?int $min = null;
	private ?int $max = null;

	/** @var array */
	public array $types = [
		self::JSON      => 'json',
		self::FLOAT     => 'float',
		self::ARRAY     => 'array',
		self::STRING    => 'string',
		self::INTEGER   => 'integer',
		self::SERIALIZE => 'serialize',
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

			return $this->{$method . 'Format'}($field, $value);
		}, $this->params, $this->method, $this->types);
	}

    /**
     * @param $field
     * @param $value
     * @return bool
     * @throws \ReflectionException
     */
	public function jsonFormat($field, $value): bool
	{
		if (is_null(json_decode($value))) {
			return $this->addError($field, 'The ' . $field . ' not is JSON data.');
		}
		return true;
	}

    /**
     * @param $field
     * @param $value
     * @return bool
     * @throws \ReflectionException
     */
	public function serializeFormat($field, $value): bool
	{
		if (false === unserialize($value)) {
			return $this->addError($field, 'The ' . $field . ' not is serialize data.');
		}
		return true;
	}

    /**
     * @param $field
     * @param $value
     * @return bool
     * @throws \ReflectionException
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
     * @throws \ReflectionException
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
     * @throws \ReflectionException
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
     * @throws \ReflectionException
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
