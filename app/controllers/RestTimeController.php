<?php 
namespace controllers;

use core\DBDriver;
use core\DbConnection;
use core\Exceptions\ValidatorException;
use core\TimeConverter;
use models\KidModel;
use models\TimeToPlayModel;

class RestTimeController extends RestController
{
    public function saveTimePlayedAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $timePlayed = $this->request->getPostParam('timePlayed');
        $timePlayed = (-1) * abs(TimeConverter::convertStrToSeconds($timePlayed));
        $currentDate = date('Y/m/d');
        
        $kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
        
        try
        {            
            $timeToPlayModel->addTime([
                'time' => $timePlayed,
                'date' => $currentDate,
                'kid_id' => $kid->getId()
            ]);
            
            $kidModel->changeKidTime($kid, $timePlayed);
        }
        catch (ValidatorException $e)
        {
            $errors = $e->getErrors();
            $this->request->addSessionParam('errors', $errors);
        }
    }
}