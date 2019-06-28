<?php
namespace controllers;

class KidTemplateController extends TemplateController
{       
    public function itemsAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentDashboardItems.html.php',
            [
                'lg_time_to_play' => $this->langManager->getLangParams()['lg_time_to_play'],
                'timeKid' => $this->request->getSessionParam('parent')->getkids()[$kidName]->mins_to_play,
                'lg_school_subjects' => $this->langManager->getLangParams()['lg_school_subjects'],
                'lg_tasks' => $this->langManager->getLangParams()['lg_tasks']
            ]
            );
    }
}