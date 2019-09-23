<?php
namespace controllers;

class SubjectBlockController extends BlockParentController
{    
    private function getKid($kidName)
    {
        $parent = $this->request->getSessionParam('parent');
        return $kidName!==null ? $parent->getKids()[$kidName] : $parent->getKids()[0];
    }
    
    public function getDashboardSubjectBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        
        $this->content = $this->buildDashboardSubjectBlock($this->getKid($kidName));;
    }
    
    public function getAddingSubjectBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        
        $this->content = $this->buildAddingSubjectBlock($this->getKid($kidName));;
    }
}