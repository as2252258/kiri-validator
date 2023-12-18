<?php
declare(strict_types=1);

namespace validator;


use Database\Model;
use Database\ModelInterface;
use Exception;


/**
 * Class \validator\BaseValidator
 */
abstract class BaseValidator
{

    public mixed $value;


    protected string $message;


    /**
     * @param string $field
     * @param float $value
     * @return bool
     * @throws Exception
     */
    public function trigger(string $field, mixed $value): bool
    {
        throw new Exception('Child Class must define method of trigger');
    }


    /**
     * @param $field
     * @param $message
     * @return bool
     */
    public function addError($field, $message): bool
    {
        if (!is_null($field)) {
            $message = str_replace(':attribute', $field, $message);
        }

        $this->message = $message;

        return false;
    }


    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->message;
    }
}
