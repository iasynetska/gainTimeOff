<?php
namespace controllers;

class TemplateController extends AbstractController
{
    protected $content;
    
    public function render()
    {
        echo $this->content;
    }
}