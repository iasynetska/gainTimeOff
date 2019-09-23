<?php
namespace controllers;

class KidBlockController extends BlockParentController
{
    public function getDashboardKidBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $parent = $this->request->getSessionParam(self::PARENT_KEY);
        $kids = $parent->getKids();
        
        $this->content = $this->buildDashboardKidBlock($kids);
    }
}