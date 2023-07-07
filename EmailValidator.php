<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/20 0020
 * Time: 17:32
 */
declare(strict_types=1);

namespace validator;


class EmailValidator extends BaseValidator
{

    /**
     * @return bool
     * 检查是否存在
     * @throws \ReflectionException
     */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params) {
			$value = $params[$field] ?? null;
            if (!filter_var($value,FILTER_VALIDATE_EMAIL)) {
                return $this->addError($field,'The param :attribute format error');
            }
            return true;
		}, $this->params);
	}

}
