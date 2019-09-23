<?php
namespace core\dto;

class Message
{
    public $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }
}