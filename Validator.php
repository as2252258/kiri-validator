<?php
declare(strict_types=1);


namespace validator;


use Closure;
use Database\ModelInterface;
use Kiri;

/**
 * Class Validator
 * @package validator
 */
class Validator extends BaseValidator
{

    /**
     * classMap
     */
    const array classMap = [
        'not empty' => ['class' => EmptyValidator::class, 'method' => EmptyValidator::CAN_NOT_EMPTY,],
        'not null'  => ['class' => EmptyValidator::class, 'method' => EmptyValidator::CAN_NOT_NULL,],
        'required'  => ['class' => RequiredValidator::class,],
        'enum'      => ['class' => EnumValidator::class,],
        'unique'    => ['class' => UniqueValidator::class,],
        'datetime'  => ['class' => DateTimeValidator::class, 'method' => DateTimeValidator::DATE_TIME,],
        'date'      => ['class' => DateTimeValidator::class, 'method' => DateTimeValidator::DATE,],
        'time'      => ['class' => DateTimeValidator::class, 'method' => DateTimeValidator::TIME,],
        'timestamp' => ['class' => DateTimeValidator::class, 'method' => DateTimeValidator::STR_TO_TIME,],
        'string'    => ['class' => TypesOfValidator::class, 'method' => TypesOfValidator::STRING,],
        'int'       => ['class' => TypesOfValidator::class, 'method' => TypesOfValidator::INTEGER,],
        'min'       => ['class' => IntegerValidator::class],
        'max'       => ['class' => IntegerValidator::class],
        'json'      => ['class' => TypesOfValidator::class, 'method' => TypesOfValidator::JSON,],
        'float'     => ['class' => TypesOfValidator::class, 'method' => TypesOfValidator::FLOAT,],
        'array'     => ['class' => TypesOfValidator::class, 'method' => TypesOfValidator::ARRAY,],
        'maxLength' => ['class' => LengthValidator::class, 'method' => LengthValidator::MAX_LENGTH,],
        'minLength' => ['class' => LengthValidator::class, 'method' => LengthValidator::MIN_LENGTH,],
        'email'     => ['class' => EmailValidator::class],
        'length'    => ['class' => LengthValidator::class],
        'round'     => ['class' => RoundValidator::class,],
    ];

    /** @var BaseValidator[] */
    private ?array $validators = [];


    /**
     * @param ModelInterface $model
     * @param array $fields
     * @param array $rules
     * @return $this
     */
    public function make(ModelInterface $model, array $fields, array $rules): static
    {
        foreach ($fields as $field) {
            if (!isset($this->validators[$field])) {
                $this->validators[$field] = [];
            }
            foreach ($rules as $key => $val) {
                if (is_numeric($key) && method_exists($model, $val)) {
                    $this->validators[$field][] = [$model, $val];
                } else {
                    $this->validators[$field][] = $this->mapGen($model, $key, $val);
                }
            }
        }
        return $this;
    }


    /**
     * @param ModelInterface $model
     * @param $key
     * @param $val
     * @return array
     * @throws
     */
    protected function mapGen(ModelInterface $model, $key, $val): array
    {
        if (is_numeric($key)) {
            $defined = self::classMap[$val];
        } else {
            $defined          = self::classMap[$key];
            $defined['value'] = $val;
        }
        if ($defined['class'] == UniqueValidator::class) {
            $defined['model'] = $model;
        }
        return [Kiri::createObject($defined), 'trigger'];
    }

    /**
     * @param ModelInterface $model
     * @return bool
     */
    public function validation(ModelInterface $model): bool
    {
        if (count($this->validators) < 1) {
            return true;
        }
        $attributes = $model->getChanges();
        foreach ($attributes as $field => $attribute) {
            if (isset($this->validators[$field])) {
                $validator = $this->validators[$field];
                foreach ($validator as $value) {
                    if (!call_user_func($value, $field, $attribute)) {
                        return $this->addError($field, 'field :attribute data format error.');
                    }
                }
            }
        }
        return true;
    }
}
