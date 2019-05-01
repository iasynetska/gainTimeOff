<?php
namespace controllers;

use core\Request;

class RestController
{
    protected $request;
    protected $content;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function render()
    {
        echo $this->content;
    }
}