<?php

namespace validator;

trait RuleTrait
{
    /**
     * @var array
     */
    protected array $classMap = [
        'not empty' => [
            'class'  => EmptyValidator::class,
            'method' => EmptyValidator::CAN_NOT_EMPTY,
        ],
        'not null'  => [
            'class'  => EmptyValidator::class,
            'method' => EmptyValidator::CAN_NOT_NULL,
        ],
        'required'  => [
            'class' => RequiredValidator::class,
        ],
        'enum'      => [
            'class' => EnumValidator::class,
        ],
        'unique'    => [
            'class' => UniqueValidator::class,
        ],
        'datetime'  => [
            'class'  => DateTimeValidator::class,
            'method' => DateTimeValidator::DATE_TIME,
        ],
        'date'      => [
            'class'  => DateTimeValidator::class,
            'method' => DateTimeValidator::DATE,
        ],
        'time'      => [
            'class'  => DateTimeValidator::class,
            'method' => DateTimeValidator::TIME,
        ],
        'timestamp' => [
            'class'  => DateTimeValidator::class,
            'method' => DateTimeValidator::STR_TO_TIME,
        ],
        'string'    => [
            'class'  => TypesOfValidator::class,
            'method' => TypesOfValidator::STRING,
        ],
        'int'       => [
            'class'  => TypesOfValidator::class,
            'method' => TypesOfValidator::INTEGER,
        ],
        'min'       => [
            'class' => IntegerValidator::class
        ],
        'max'       => [
            'class' => IntegerValidator::class
        ],
        'json'      => [
            'class'  => TypesOfValidator::class,
            'method' => TypesOfValidator::JSON,
        ],
        'float'     => [
            'class'  => TypesOfValidator::class,
            'method' => TypesOfValidator::FLOAT,
        ],
        'array'     => [
            'class'  => TypesOfValidator::class,
            'method' => TypesOfValidator::ARRAY,
        ],
        'maxlength' => [
            'class'  => LengthValidator::class,
            'method' => 'max',
        ],
        'minlength' => [
            'class'  => LengthValidator::class,
            'method' => 'min',
        ],
        'email'     => [
            'class'  => EmailValidator::class,
            'method' => 'email',
        ],
        'length'    => [
            'class'  => LengthValidator::class,
            'method' => 'default',
        ],
        'round'     => [
            'class' => RoundValidator::class,
        ],
    ];
}