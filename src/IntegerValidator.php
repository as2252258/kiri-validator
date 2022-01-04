<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/4 0004
 * Time: 18:44
 */
declare(strict_types=1);

namespace validator;


class IntegerValidator extends BaseValidator
{

	const MIN = 'min';
	const MAX = 'max';

	public ?int $value = null;
	private string $type = '';

	/**
	 * @return bool
	 */
	public function trigger(): bool
	{
		if (empty($this->params) || !isset($this->params[$this->field])) {
			return true;
		}
		if ($this->type !== self::MIN && $this->params[$this->field] < $this->value) {
			return $this->addError('The ' . $this->field . ' cannot be less than the default value.');
		}
		if ($this->type !== self::MAX && $this->params[$this->field] > $this->value) {
			return $this->addError('The ' . $this->field . ' cannot be greater than the default value.');
		}
		return true;
	}
}
