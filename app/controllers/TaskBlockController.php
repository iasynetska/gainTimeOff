<?php
namespace controllers;

class TaskBlockController extends BlockParentController
{    
    private function getKid($kidName)
    {
        $parent = $this->request->getSessionParam('parent');
        return $kidName!==null ? $parent->getKids()[$kidName] : $parent->getKids()[0];
    }
    
    public function getDashboardTaskBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        
        $this->content = $this->buildDashboardTaskBlock($this->getKid($kidName));;
    }
    
    public function getAddingTaskBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        
        $this->content = $this->buildAddingTaskBlock($this->getKid($kidName));;
    }
}