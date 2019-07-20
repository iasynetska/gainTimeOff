<?php
namespace controllers;

class SubjectTemplateController extends TemplateController
{       
    public function subjectsAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/subjectBlock.html.php',
            [
                'lg_add_subjects_title' => $this->langManager->getLangParams()['lg_add_subjects_title'],
                'lg_new_subject' => $this->langManager->getLangParams()['lg_new_subject'],
                'error_subject' => isset($this->request->getSessionParam('errors')['subject']) ? $this->buildErrorMessage($this->request->getSessionParam('errors')['subject']) : '',
                'lg_school_subjects' => $this->langManager->getLangParams()['lg_school_subjects'],
                'subjects' => $kid->getKidSubjects(),
                'lg_sub_exist' => $this->langManager->getLangParams()['lg_sub_exist'],
                'kidName' => $kid->name,
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
    }
}