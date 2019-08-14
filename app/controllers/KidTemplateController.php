<?php
namespace controllers;

use core\TimeConverter;

class KidTemplateController extends TemplateController
{       
    public function itemsAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getkids()[$kidName];
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentDashboardItems.html.php',
            [
                'lg_time_to_play' => $this->langManager->getLangParams()['lg_time_to_play'],
                'kidTime' => TimeConverter::convertSecondsToTimeFormat($kid->time_to_play),
                'lg_school_subjects' => $this->langManager->getLangParams()['lg_school_subjects'],
                'lg_create_new' =>$this->langManager->getLangParams()['lg_create_new'],
                'subjects' => $kid->getKidSubjects(),
                'kidName' => $kidName,
                'lg_select_subject' => $this->langManager->getLangParams()['lg_select_subject'],
                'lg_add_subjects_title' => $this->langManager->getLangParams()['lg_add_subjects_title'],
                'lg_add_marks_title' => $this->langManager->getLangParams()['lg_add_marks_title'],
                'lg_select_mark' => $this->langManager->getLangParams()['lg_select_mark'],
                'marks' => $kid->getKidMarks(),
                'lg_tasks' => $this->langManager->getLangParams()['lg_tasks'],
                'tasks' => $kid->getKidTasks(),
                'lg_select_task' => $this->langManager->getLangParams()['lg_select_task'],
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
    }
}