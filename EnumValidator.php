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
		return $this->_validator($this->field, function ($field, $params, $values) {
			if (!in_array($params[$field] ?? null, $values)) {
				$message =  'The param :attribute value(' . $params[$field] . ') only in ' . implode(',', $values);
				return $this->addError($field, $message);
			}
			return true;
		}, $this->params, $this->value);
	}

}
