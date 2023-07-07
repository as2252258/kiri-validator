<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:28
 */
declare(strict_types=1);

namespace validator;


use ReflectionException;

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
     * @throws ReflectionException
     */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params) {
			$value = $params[$field] ?? null;
			if (!is_array($value)) {
				return $this->addError($field, 'The param :attribute must a array');
			}
			return true;
		}, $this->params);
	}

}
