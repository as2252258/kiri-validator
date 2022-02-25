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
			if (empty($value)) {
				return $this->addError($field,'The param :attribute is null');
			}
			if (!in_array($value, $values)) {
				return $this->addError($field,'The param :attribute value only in ' . implode(',', $values));
			}
			return true;
		}, $this->params, $this->value);
	}

}
