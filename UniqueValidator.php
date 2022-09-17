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
		if (empty($this->model)) {
			return $this->addError('model','Model error.');
		}
		if (!$this->model->getIsNowExample()) {
			return true;
		}
		return $this->_validator($this->field, function ($_item, $params, $model) {
			if (!is_array($_item)) {
				$_item = [$_item];
			}
			$data = array_reduce($_item, function ($resp, $next) use ($params) {
				$array = empty($resp) ? [] : $resp;
				$array[$next] = $params[$next] ?? null;
				return $array;
			});
			if ($model::query()->where($data)->exists()) {
				return $this->addError(implode(',', $_item),
					'The :attribute \'' . implode(',', $_item) . '\' is exists!');
			}
			return $this->isFail = TRUE;
		}, $this->params, $this->model);
	}


}
