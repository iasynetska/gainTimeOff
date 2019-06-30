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
                'lg_create_new' =>$this->langManager->getLangParams()['lg_create_new'],
                'subjects' => $this->request->getSessionParam('parent')->getkids()[$kidName]->getKidSubjects(),
                'lg_select_subject' => $this->langManager->getLangParams()['lg_select_subject'],
                'lg_select_mark' => $this->langManager->getLangParams()['lg_select_mark'],
                'marks' => $this->request->getSessionParam('parent')->getkids()[$kidName]->getKidMarks(),
                'lg_tasks' => $this->langManager->getLangParams()['lg_tasks'],
                'tasks' => $this->request->getSessionParam('parent')->getkids()[$kidName]->getKidTasks(),
                'lg_select_task' => $this->langManager->getLangParams()['lg_select_task']
            ]
            );
    }
}