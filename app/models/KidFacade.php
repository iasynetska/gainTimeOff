<?php
namespace models;

use core\DbConnection;
use core\ComplitedTaskDBDriver;
use core\Request;
use models\entities\UserKid;
use core\GotMarkDBDriver;
use core\DBDriver;

class KidFacade
{
    private $request;
    private $complitedTaskModel;
    private $gotMarkModel;
    private $kidModel;
    private $markModel;
    private $subjectModel;
    private $timeToPlayModel;
    private $taskModel;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->complitedTaskModel = new ComplitedTaskModel(new ComplitedTaskDBDriver(DbConnection::getPDO()));
        $this->gotMarkModel = new GotMarkModel(new GotMarkDBDriver(DbConnection::getPDO()));
        $this->kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $this->markModel = new MarkModel(new DBDriver(DbConnection::getPDO()));
        $this->markModel = new MarkModel(new DBDriver(DbConnection::getPDO()));
        $this->timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
        $this->taskModel = new TaskModel(new DBDriver(DbConnection::getPDO()));        
        $this->subjectModel = new SubjectModel(new DBDriver(DbConnection::getPDO()));
    }
    
    public function deleteKidAndRelativeItems(UserKid $kid)
    {
        DbConnection::getPDO()->beginTransaction();
        
        $this->complitedTaskModel->deleteComplitedTasksByKid($kid);
        $this->gotMarkModel->deleteGotMarksByKId($kid);
        $this->timeToPlayModel->deleteTimeToPlayByKid($kid);
        $this->taskModel->deleteTasksByKid($kid);
        $this->markModel->deleteMarksByKid($kid);
        $this->subjectModel->deleteSubjectsByKid($kid);
        $this->kidModel->deleteKid($kid);
               
        DbConnection::getPDO()->commit();
        
        $parent = $this->request->getSessionParam('parent');
        $parent->resetKids();
    }
}