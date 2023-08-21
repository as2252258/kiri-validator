<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 17:04
 */
declare(strict_types=1);

namespace validator;


use ReflectionException;

class LengthValidator extends BaseValidator
{

	const MAX_LENGTH = 'max';
	const MIN_LENGTH = 'min';

	public string $method;

	public int $value;

    /**
     * @return bool
     * @throws ReflectionException
     */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params, $method, $length) {
			$value = $params[$field] ?? null;
			return match ($method) {
				self::MAX_LENGTH => $this->maxLength($field, (string)$value),
				self::MIN_LENGTH => $this->minLength($field, (string)$value),
				default => $this->defaultLength($field, (string)$value),
			};
		}, $this->params, strtolower($this->method), $this->value);
	}

    /**
     * @param $field
     * @param $value
     * @return bool
     *
     * 效验长度是否大于最大长度
     */
	private function maxLength($field, $value): bool
	{
		if (is_array($value)) {
			if (count($value) > $value) {
				return $this->addError($field, 'The param :attribute length overflow');
			}
		} else {
			if (is_numeric($value) && strlen((string)$value) > $this->value) {
				return $this->addError($field, 'The param :attribute length overflow');
			}
			if (strlen($value) > $this->value) {
				return $this->addError($field, 'The param :attribute length overflow');
			}
		}
		return TRUE;
	}

    /**
     * @param $field
     * @param $value
     * @return bool
     *
     * 效验长度是否小于最小长度
     */
	private function minLength($field, $value): bool
	{
		if (is_array($value)) {
			if (count($value) < $value) {
				return $this->addError($field, 'The param :attribute length error');
			}
		} else {
			if (is_numeric($value) && strlen((string)$value) < $this->value) {
				return $this->addError($field, 'The param :attribute length overflow');
			}
			if (strlen($value) < $this->value) {
				return $this->addError($field, 'The param :attribute length error');
			}
		}
		return TRUE;
	}

    /**
     * @param $field
     * @param $value
     * @return bool
     *
     * 效验长度是否小于最小长度
     */
	private function defaultLength($field, $value): bool
	{
		if (is_array($value)) {
			if (count($value) !== $value) {
				return $this->addError($field, 'The param :attribute length error');
			}
		} else {
			if (is_numeric($value) && strlen((string)$value) !== $this->value) {
				return $this->addError($field, 'The param :attribute length overflow');
			}
			if (mb_strlen($value) !== $this->value) {
				return $this->addError($field, 'The param :attribute length error; ' . mb_strlen($value) . ':' . $this->value);
			}
		}
		return TRUE;
	}
}
