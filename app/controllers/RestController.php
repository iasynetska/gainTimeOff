<?php
namespace controllers;

class RestController extends AbstractController
{
    protected $content;
    
    public function render()
    {
        echo json_encode($this->content);
    }
}