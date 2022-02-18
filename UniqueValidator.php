<?php
/**
 * Created by PhpStorm.
 * User: qv
 * Date: 2018/10/16 0016
 * Time: 10:24
 */
declare(strict_types=1);

namespace validator;


class UniqueValidator extends BaseValidator
{

	/**
	 * @return bool
	 * @throws
	 * 检查是否存在
	 */
	public function trigger(): bool
	{
		if (empty($model)) {
			return $this->addError('Model error.');
		}
		if (!$model->getIsNowExample()) {
			return true;
		}
		return $this->_validator($this->field, function ($field, $params, $model) {
			if (!isset($params[$field])) {
				return true;
			}
			$param = $params[$field];
			if ($model::query()->where([$field => $param])->exists()) {
				return $this->addError('The :attribute \'' . $param . '\' is exists!');
			}
			return $this->isFail = TRUE;
		}, $this->params, $this->model);
	}


}
