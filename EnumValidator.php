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
			$value = $params[$field] ?? null;
			if (is_null($value)) {
				return true;
			}
			if ($value === '') {
				return $this->addError($field, 'The param :attribute value con\'t empty.');
			}
			if (!in_array($value, $values)) {
				$message = 'The param :attribute value(' . $value . ') only in ' . implode(',', $values);
				return $this->addError($field, $message);
			}
			return true;
		}, $this->params, $this->value);
	}

}
