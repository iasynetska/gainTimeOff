<?php
namespace controllers;

class TimeBlockController extends BlockParentController
{       
    
    private function getKid($kidName)
    {
        $parent = $this->request->getSessionParam('parent');
        return $kidName!==null ? $parent->getKids()[$kidName] : $parent->getKids()[0];
    }
    
    public function getDashboardTimeBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        
        $this->content = $this->buildDashboardTimeBlock($this->getKid($kidName));;
    }
}