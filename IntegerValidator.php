<?php
/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2018/4/4 0004
 * Time: 18:44
 */
declare(strict_types=1);

namespace validator;


/**
 *
 */
class IntegerValidator extends BaseValidator
{

	const MIN = 'min';
	const MAX = 'max';

	public ?int $value = null;
	private string $type = '';

    /**
     * @return bool
     */
	public function trigger(): bool
	{
		return $this->_validator($this->field, function ($field, $params, $origin, $type) {
			$value = $params[$field] ?? null;
			if ($type !== self::MIN && $value < $origin) {
				return $this->addError($field,'The ' . $field . ' cannot be less than the default value.');
			}
			if ($type !== self::MAX && $value > $origin) {
				return $this->addError($field,'The ' . $field . ' cannot be greater than the default value.');
			}
			return true;
		}, $this->params, $this->value, $this->type);
	}
}
