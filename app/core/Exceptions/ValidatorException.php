<?php
namespace core\Exceptions;

class ValidatorException extends \Exception
{
    private $errors;
    
    public function __construct($errors)
    {
        parent::__construct('');
        $this->errors = $errors;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}