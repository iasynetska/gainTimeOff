<?php
namespace controllers;

class BlockParentController extends ParentController
{
    protected $content;
    
    public function render()
    {
        echo $this->content;
    }
}