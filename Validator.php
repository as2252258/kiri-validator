<?php
declare(strict_types=1);


namespace validator;


use Closure;
use Database\ModelInterface;
use Exception;
use Kiri;

/**
 * Class Validator
 * @package validator
 */
class Validator extends BaseValidator
{

    use RuleTrait;

    /** @var BaseValidator[] */
    private ?array $validators = [];


    /**
     * @param array $params
     * @param ModelInterface $model
     * @return Validator
     */
    public static function instance(array $params, ModelInterface $model): static
    {
        $validator = new Validator();
        $validator->setParams($params);
        $validator->setModel($model);
        return $validator;
    }

    /**
     * @param $field
     * @param $rules
     * @return $this
     * @throws Exception
     */
    public function make($field, $rules): static
    {
        if (!is_array($field)) {
            $field = [$field];
        }

        $param = $this->getParams();
        $model = $this->getModel();

        $this->createRule($field, $rules, $model, $param);

        return $this;
    }

    /**
     * @param $field
     * @param $rule
     * @param $model
     * @param $param
     * @throws Exception
     * ['maxLength'=>150, 'required', 'minLength' => 100]
     */
    public function createRule($field, $rule, $model, $param): void
    {
        $define = ['field' => $field];
        foreach ($rule as $key => $val) {
            if (is_string($key)) {
                $type = strtolower($key);
                $define['value'] = $val;
            } else {
                $type = strtolower($val);
            }
            if (!isset($this->classMap[$type])) {
                $this->validators[] = [$model, $val];
            } else {
                $merge = array_merge($this->classMap[$type], $define, [
                    'params' => $param,
                    'model'  => $model
                ]);
                $this->validators[] = $merge;
            }
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validation(): bool
    {
        if (count($this->validators) < 1) {
            return true;
        }
        foreach ($this->validators as $val) {
            [$result, $validator] = $this->check($val);
            if ($result === true) {
                continue;
            }
            $isTrue = false;
            if ($validator instanceof BaseValidator) {
                $this->addError(null, $validator->getError());
            }
            break;
        }
        $this->validators = [];
        return !isset($isTrue);
    }

    /**
     * @param BaseValidator|array|Closure $val
     * @return array
     * @throws Exception
     */
    private function check(BaseValidator|array|Closure $val): array
    {
        if (is_callable($val, true)) {
            return [call_user_func($val, $this), $val];
        }

        $class = Kiri::getDi()->get($val['class']);
        unset($val['class']);

        Kiri::configure($class, $val);

        return [$class->trigger(), $class];
    }

}
