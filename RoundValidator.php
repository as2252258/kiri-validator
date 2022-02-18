<?php


namespace validator;


use Exception;

/**
 * Class RoundValidator
 * @package validator
 */
class RoundValidator extends BaseValidator
{


	public ?int $value = null;


	/**
	 * @return bool
	 * @throws Exception
	 */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $model, $param) {
			$value = $model->getAttribute($field);
			if ($value == null || round($value, $param) != $value) {
				return $this->addError('The param :attribute length error');
			}
			return true;
		},  $this->model, $this->value);
	}


}
