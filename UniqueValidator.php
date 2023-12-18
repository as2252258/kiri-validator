<?php
/**
 * Created by PhpStorm.
 * User: qv
 * Date: 2018/10/16 0016
 * Time: 10:24
 */
declare(strict_types=1);

namespace validator;


use Database\ModelInterface;

class UniqueValidator extends BaseValidator
{


    /**
     * @var ModelInterface
     */
    public ModelInterface $model;


    /**
     * @param string $field
     * @param mixed $value
     * @return bool
     * @throws
     * 检查是否存在
     */
    public function trigger(string $field, mixed $value): bool
    {
        return $this->model::query()->where([$field => $value])->exists() === false;
    }


}
