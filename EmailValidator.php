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
	 */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params) {
			$value = $params[$field] ?? null;
			if (empty($value)) {
				return true;
			}
			$exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
			if (!preg_match($exp, $value)) {
				return $this->addError($field,'The param :attribute format error');
			}
			[$account, $domain] = explode("@", $value);
			if (checkdnsrr($domain, "MX")) {
				return true;
			}
			return $this->addError($field,'The param :attribute format error');
		}, $this->params);
	}

}
