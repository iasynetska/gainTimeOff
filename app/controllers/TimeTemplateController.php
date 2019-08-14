<?php
namespace controllers;

use core\TimeConverter;

class TimeTemplateController extends TemplateController
{       
    public function timeAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        
        $this->content = TimeConverter::convertSecondsToTimeFormat($kid->time_to_play);
    }
}