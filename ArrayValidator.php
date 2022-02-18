<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:28
 */
declare(strict_types=1);

namespace validator;


/**
 * Class ArrayValidator
 * @package validator
 */
class ArrayValidator extends BaseValidator
{

	/**
	 * @return bool
	 *
	 * 检查
	 */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params) {
			$value = $params[$field] ?? null;
			if (empty($value)) {
				return true;
			}
			if (!is_array($value)) {
				return $this->addError('The param :attribute must a array');
			}
			return true;
		}, $this->params);
	}

}
