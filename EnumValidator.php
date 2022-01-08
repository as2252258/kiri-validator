<?php

declare(strict_types=1);

namespace validator;



/**
 * Class EnumValidator
 * @package validator
 */
class EnumValidator extends BaseValidator
{

	public array $value = [];

	/**
	 * @return bool
	 */
	public function trigger(): bool
	{
		if (empty($this->params) || !isset($this->params[$this->field])) {
			return $this->addError('The param :attribute is null');
		}
		if (is_null($this->params[$this->field])) {
			return $this->addError('The param :attribute is null');
		}
		if (!in_array($this->params[$this->field], $this->value)) {
			return $this->addError($this->i());
		}
		return true;
	}

	/**
	 * @return string
	 */
	private function i(): string
	{
		return 'The param :attribute value only in ' . implode(',', $this->value);
	}

}
