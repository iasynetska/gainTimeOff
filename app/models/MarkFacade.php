<?php
namespace models;

use core\DbConnection;
use core\DBDriver;
use core\ReceivedMarkDBDriver;
use models\entities\Mark;
use models\entities\Subject;
use models\entities\UserKid;
use Exception;

class MarkFacade
{
    private $kidModel;
    private $receivedMarkModel;
    private $timeToPlayModel;
    
    public function __construct()
    {
        $this->kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $this->receivedMarkModel = new ReceivedMarkModel(new ReceivedMarkDBDriver(DbConnection::getPDO()));
        $this->timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
    }
    
    public function saveReceivedMarkAndChangeKidTime(UserKid $kid, Subject $subject, Mark $mark)
    {
        try {
            DbConnection::getPDO()->beginTransaction();
            
            $this->timeToPlayModel->saveTime([
                'time' => $mark->gameTime,
                'date' => date('Y/m/d'),
                'kid_id' => $kid->getId()
            ]);
            
            $this->receivedMarkModel->saveReceivedMark([
                'subject_id' => $subject->getId(),
                'mark_id' => $mark->getId(),
                'date' => date('Y/m/d')
            ]);
            
            $this->kidModel->changeKidTime($kid, $mark->gameTime);
            
            DbConnection::getPDO()->commit();
        } 
        catch (Exception $e) 
        {
            DbConnection::getPDO()->rollBack();
            throw $e;
        }
    }
}