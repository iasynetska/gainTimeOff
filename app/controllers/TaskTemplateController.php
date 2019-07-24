<?php
namespace controllers;

class TaskTemplateController extends TemplateController
{       
    public function tasksAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/taskBlock.html.php',
            [
                'lg_add_tasks_title' => $this->langManager->getLangParams()['lg_add_tasks_title'],
                'lg_new_task' => $this->langManager->getLangParams()['lg_new_task'],
                'error_task' => isset($this->request->getSessionParam('errors')['task']) ? $this->buildErrorMessage($this->request->getSessionParam('errors')['task']) : '',
                'tasks' => $kid->getKidTasks(),
                'lg_task_exist' => $this->langManager->getLangParams()['lg_task_exist'],
                'kidName' => $kid->name,
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
    }
}