<?php 
namespace controllers;

use \Exception;
use core\DBDriver;
use core\DbConnection;
use core\Exceptions\ValidatorException;
use core\TimeConverter;
use core\dto\Message;
use models\MarkModel;
use models\MarkFacade;

class RestMarkController extends RestController
{
    const ACTIVE = 1;
    
    public function doSavingMarkAction()
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
                $MarkModel->saveMark([
                    'name' => $mark->name,
                    'gameTime' => TimeConverter::convertStrToSeconds($mark->gameTime),
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
    
    public function saveReceivedMarkAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $subjectName = $this->request->getPostParam('subjectName');
        $subject = $kid->getKidSubjects()[$subjectName];
        $markName = $this->request->getPostParam('markName');
        $mark = $kid->getKidMarks()[$markName];
        
        $markFacade = new MarkFacade();
        
        try
        {
            $markFacade->saveReceivedMarkAndChangeKidTime($kid, $subject, $mark);
        }
        catch (Exception $e)
        {
            $this->content = new Message($e->getMessage());
            http_response_code(500);
        }
    }
}