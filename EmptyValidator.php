<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:46
 */

declare(strict_types=1);


namespace validator;


class EmptyValidator extends BaseValidator
{

	/** @var string [不能为空] */
	const CAN_NOT_EMPTY = 'not empty';

	/** @var string [可为空, 不能为null] */
	const CAN_NOT_NULL = 'not null';

	public string $method;

	/**
	 * @return bool
	 *
	 * 检查参数是否为NULL
	 */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params, $method) {
			$value = $params[$field] ?? null;
			if (empty($value)) {
				return $this->addError($field,':attribute not exists');
			}
			return match ($method) {
				self::CAN_NOT_EMPTY => isset($value[1]) || $this->addError($field,'The :attribute can not empty.'),
				default => $value !== null || $this->addError($field,'The :attribute can not empty.')
			};
		}, $this->params, strtolower($this->method));
	}
}
