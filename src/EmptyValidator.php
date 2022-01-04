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
		if (empty($this->params) || !isset($this->params[$this->field])) {
			return $this->addError(':attribute not exists');
		}
		switch (strtolower($this->method)) {
			case self::CAN_NOT_EMPTY:
				if (strlen($this->params[$this->field]) < 1) {
					return $this->addError('The :attribute can not empty.');
				}
				break;
			case self::CAN_NOT_NULL:
				if ($this->params[$this->field] === null) {
					return $this->addError('The :attribute can not is null.');
				}
				break;
		}
		return true;
	}
}
