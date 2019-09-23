<?php 
namespace controllers;

use \Exception;
use core\DBDriver;
use core\DbConnection;
use core\GotMarkDBDriver;
use core\Exceptions\ValidatorException;
use core\TimeConverter;
use models\GotMarkModel;
use models\KidModel;
use models\MarkModel;
use models\TimeToPlayModel;

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
    
    public function saveGotMarkAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $subjectName = $this->request->getPostParam('subjectName');
        $subject = $kid->getKidSubjects()[$subjectName];
        $markName = $this->request->getPostParam('markName');
        $mark = $kid->getKidMarks()[$markName];
        $currentDate = date('Y/m/d');
        
        $kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $gotMarkModel = new GotMarkModel(new GotMarkDBDriver(DbConnection::getPDO()));
        $timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
        
        try
        {
            DbConnection::getPDO()->beginTransaction();
            
            $timeToPlayModel->saveTime([
                'time' => $mark->gameTime,
                'date' => $currentDate,
                'kid_id' => $kid->getId()
            ]);
            
            $gotMarkModel->saveGotMark([
                'subject_id' => $subject->getId(),
                'mark_id' => $mark->getId(),
                'date' => $currentDate
            ]);
            
            $kidModel->changeKidTime($kid, $mark->gameTime);
            
            DbConnection::getPDO()->commit();
        }
        catch (ValidatorException $e)
        {
            $errors = $e->getErrors();
            $this->request->addSessionParam('errors', $errors);
            DbConnection::getPDO()->rollBack();
        }
        catch (Exception $e)
        {
            DbConnection::getPDO()->rollBack();
            http_response_code(400);
            throw $e->getMessage();
        }
    }
}