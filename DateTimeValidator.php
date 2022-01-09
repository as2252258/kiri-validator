<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/3 0003
 * Time: 15:42
 */
declare(strict_types=1);

namespace validator;


class DateTimeValidator extends BaseValidator
{
	
	const DATE = 'date';
	const DATE_TIME = 'datetime';
	const TIME = 'time';
	const STR_TO_TIME = 'timestamp';

	public string $method;
	
	/**
	 * @return bool
	 */
	public function trigger(): bool
	{
		if (empty($this->params)) {
			return true;
		}
		if (!isset($this->params[$this->field]) || empty($this->params[$this->field])) {
			return true;
		}
		return match (strtolower($this->method)) {
			self::DATE => $this->validatorDate($this->params[$this->field]),
			self::DATE_TIME => $this->validateDatetime($this->params[$this->field]),
			self::TIME => $this->validatorTime($this->params[$this->field]),
			self::STR_TO_TIME => $this->validatorTimestamp($this->params[$this->field]),
			default => true,
		};
	}
	
	/**
	 * @param $value
	 * @return bool
	 *
	 * 效验分秒 格式如  01:02 or 01-02
	 */
	public function validatorTime($value): bool
	{
		if (empty($value) || !is_string($value)) {
			return $this->addError('The param :attribute not is a date value');
		}
		$match = preg_match('/^[0-5]?\d{1}.{1}[0-5]?\d{1}$/', $value, $result);
		if ($match && $result[0] == $value) {
			return true;
		} else {
			return $this->addError('The param :attribute format error');
		}
	}
	
	
	/**
	 * @param $value
	 * @return bool
	 *
	 * 效验分秒 格式如 2017-12-22 01:02
	 */
	public function validateDatetime($value): bool
	{
		if (empty($value) || !is_string($value)) {
			return $this->addError('The param :attribute not is a date value');
		}
		$match = '/^\d{4}\-\d{2}\-\d{2}\s+\d{2}:\d{2}:\d{2}$/';
		$match = preg_match($match, $value, $result);
		if ($match && $result[0] == $value) {
			return true;
		} else {
			return $this->addError('The param :attribute format error');
		}
	}
	
	/**
	 * @param $value
	 * @return bool
	 *
	 * 效验分秒 格式如  2017-12-22
	 */
	public function validatorDate($value): bool
	{
		if (empty($value) || !is_string($value)) {
			return $this->addError('The param :attribute not is a date value');
		}
		$match = preg_match('/^(\d{4}).*([0-12]).*([0-31]).*$/', $value, $result);
		if ($match && $result[0] == $value) {
			return true;
		} else {
			return $this->addError('The param :attribute format error');
		}
	}
	
	/**
	 * @param $value
	 * @return bool
	 *
	 * 效验时间戳 格式如  1521452254
	 */
	public function validatorTimestamp($value): bool
	{
		if (empty($value) || !is_numeric($value)) {
			return $this->addError('The param :attribute not is a timestamp value');
		}
		if (strlen((string)$value) != 10) {
			return $this->addError('The param :attribute not is a timestamp value');
		}
		if (!date('YmdHis', $value)) {
			return $this->addError('The param :attribute format error');
		}
		return true;
	}
}
