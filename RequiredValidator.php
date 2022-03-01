<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:47
 */
declare(strict_types=1);

namespace validator;


class RequiredValidator extends BaseValidator
{

	/**
	 * @return bool
	 * 检查是否存在
	 */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params) {
			if (!isset($params[$field])) {
				return $this->addError($field,'The param :attribute not exists');
			} else {
				return true;
			}
		}, $this->params);
	}

}
