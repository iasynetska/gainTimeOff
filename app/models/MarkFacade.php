<?php
namespace models;

use core\DbConnection;
use core\DBDriver;
use core\GotMarkDBDriver;
use models\entities\Mark;
use models\entities\Subject;
use models\entities\UserKid;
use Exception;

class MarkFacade
{
    private $kidModel;
    private $gotMarkModel;
    private $timeToPlayModel;
    
    public function __construct()
    {
        $this->kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $this->gotMarkModel = new GotMarkModel(new GotMarkDBDriver(DbConnection::getPDO()));
        $this->timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
    }
    
    public function saveGotMarkAndChangeKidTime(UserKid $kid, Subject $subject, Mark $mark)
    {
        try {
            DbConnection::getPDO()->beginTransaction();
            
            $this->timeToPlayModel->saveTime([
                'time' => $mark->gameTime,
                'date' => date('Y/m/d'),
                'kid_id' => $kid->getId()
            ]);
            
            $this->gotMarkModel->saveGotMark([
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