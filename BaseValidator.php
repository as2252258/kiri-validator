<?php
declare(strict_types=1);

namespace validator;


use Exception;


/**
 * Class \validator\BaseValidator
 */
abstract class BaseValidator
{

    public mixed $value;


    protected string $message;


    /**
     * @param float $value
     * @return bool
     * @throws Exception
     */
    public function trigger(mixed $value): bool
    {
        throw new Exception('Child Class must define method of trigger');
    }


    /**
     * @param string $field
     * @param string $message
     * @return bool
     */
    public function addError(string $field, string $message): bool
    {
        $this->message = str_replace(':attribute', $field, $message);
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
