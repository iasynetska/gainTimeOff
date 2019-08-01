<?php
namespace controllers;

class MarkTemplateController extends TemplateController
{       
    public function marksAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/markBlock.html.php',
            [
                'lg_add_marks_title' => $this->langManager->getLangParams()['lg_add_marks_title'],
                'lg_new_mark' => $this->langManager->getLangParams()['lg_new_mark'],
                'error_mark' => isset($this->request->getSessionParam('errors')['mark']) ? $this->buildErrorMessage($this->request->getSessionParam('errors')['mark']) : '',
                'marks' => $kid->getKidMarks(),
                'lg_mark_exist' => $this->langManager->getLangParams()['lg_mark_exist'],
                'kidName' => $kid->name,
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
    }
}