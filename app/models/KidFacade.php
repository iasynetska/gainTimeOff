<?php
namespace models;

use core\DbConnection;
use core\CompletedTaskDBDriver;
use core\Request;
use models\entities\UserKid;
use core\ReceivedMarkDBDriver;
use core\DBDriver;

class KidFacade
{
    private $request;
    private $completedTaskModel;
    private $receivedMarkModel;
    private $kidModel;
    private $markModel;
    private $subjectModel;
    private $timeToPlayModel;
    private $taskModel;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->completedTaskModel = new CompletedTaskModel(new CompletedTaskDBDriver(DbConnection::getPDO()));
        $this->receivedMarkModel = new ReceivedMarkModel(new ReceivedMarkDBDriver(DbConnection::getPDO()));
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
        
        $this->completedTaskModel->deleteCompletedTasksByKid($kid);
        $this->receivedMarkModel->deleteReceivedMarksByKId($kid);
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