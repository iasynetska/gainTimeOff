<?php
namespace core\dto;

class ErrorMessage
{
    public $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }
}