<?php
namespace models;

use core\DbConnection;
use core\DBDriver;
use models\entities\Task;
use models\entities\UserKid;
use core\CompletedTaskDBDriver;
use Exception;

class TaskFacade
{
    private $kidModel;
    private $completedTaskModel;
    private $timeToPlayModel;
    
    public function __construct()
    {
        $this->kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $this->completedTaskModel = new CompletedTaskModel(new CompletedTaskDBDriver(DbConnection::getPDO()));
        $this->timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
    }
    
    public function saveCompletedTaskAndChangeKidTime(UserKid $kid, Task $task)
    {
        try {
            DbConnection::getPDO()->beginTransaction();
            
            $this->timeToPlayModel->saveTime([
                'time' => $task->gameTime,
                'date' => date('Y/m/d'),
                'kid_id' => $kid->getId()
            ]);
            
            $this->completedTaskModel->saveCompletedTask([
                'task_id' => $task->getId(),
                'date' => date('Y/m/d')
            ]);
            
            $this->kidModel->changeKidTime($kid, $task->gameTime);
            
            DbConnection::getPDO()->commit();
        } 
        catch (Exception $e) 
        {
            DbConnection::getPDO()->rollBack();
            throw $e;
        }
    }
}