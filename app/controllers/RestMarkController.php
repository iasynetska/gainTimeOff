<?php 
namespace controllers;

use models\MarkModel;
use core\DBDriver;
use core\DbConnection;
use core\Exceptions\ValidatorException;

class RestMarkController extends RestController
{
    const ACTIVE = 1;
    
    public function doAddingMarkAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $marks = $this->request->getPostParam('marks');     
        $marks = json_decode($marks);
        
        $MarkModel = new MarkModel(new DBDriver(DbConnection::getPDO()));
        
        foreach ($marks as $mark)
        {
            try
            {
                $MarkModel->addMark([
                    'name' => $mark->name,
                    'gameTime' => $mark->gameTime,
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
        
        $kid->resetMarks();
    }
}