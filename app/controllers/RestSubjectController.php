<?php 
namespace controllers;

use core\DBDriver;
use core\DbConnection;
use core\Exceptions\ValidatorException;
use models\SubjectModel;

class RestSubjectController extends RestController
{
    const ACTIVE = 1;
    
    public function doSavingSubjectAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $subjects = $this->request->getPostParam('subjects');     
        $subjects = json_decode($subjects);
        
        $SubjectModel = new SubjectModel(new DBDriver(DbConnection::getPDO()));
        
        foreach ($subjects as $subject)
        {
            try
            {
                $SubjectModel->saveSubject([
                    'name' => $subject,
                    'active' => self::ACTIVE,
                    'kid_id' => $kid->getId()
                ]);
            }
            catch (ValidatorException $e)
            {
                $errors = $e->getErrors();
                $this->request->addSessionParam('errors', $errors);
                $this->redirect('/gaintimeoff/parent/adding-subjects-marks');
            }
        }
        
        $kid->resetSubjects();
    }
}