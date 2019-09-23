<?php
namespace controllers;

class MarkBlockController extends BlockParentController
{   
    private function getKid($kidName)
    {
        $parent = $this->request->getSessionParam('parent');
        return $kidName!==null ? $parent->getKids()[$kidName] : $parent->getKids()[0];
    }
    
    public function getAddingMarkBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        
        $this->content = $this->buildAddingMarkBlock($this->getKid($kidName));
    }
}