<?php 
namespace controllers;

use models\TaskModel;
use models\DoneTaskModel;
use models\KidModel;
use core\DBDriver;
use core\DbConnection;
use core\Exceptions\ValidatorException;
use models\TimeToPlayModel;
use core\TimeConverter;

class RestTaskController extends RestController
{
    const ACTIVE = 1;
    
    public function doAddingTaskAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $tasks = $this->request->getPostParam('tasks');     
        $tasks = json_decode($tasks);
        
        $TaskModel = new TaskModel(new DBDriver(DbConnection::getPDO()));
        
        foreach ($tasks as $task)
        {
            try
            {
                $TaskModel->addTask([
                    'name' => $task->name,
                    'gameTime' => TimeConverter::convertStrToSeconds($task->gameTime),
                    'active' => self::ACTIVE,
                    'kid_id' => $kid->getId()
                ]);
            }
            catch (ValidatorException $e)
            {
                $errors = $e->getErrors();
                $this->request->addSessionParam('errors', $errors);
                $this->redirect('/gaintimeoff/parent/adding-tasks');
            }
        }
        
        $kid->resetTasks();
    }
    
    
    public function saveDoneTaskAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $taskName = $this->request->getPostParam('taskName');
        $task = $kid->getKidTasks()[$taskName];
        $currentDate = date('Y/m/d');
        
        $kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $doneTaskModel = new DoneTaskModel(new DBDriver(DbConnection::getPDO()));
        $timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
        
        try
        {
            $timeToPlayModel->addTime([
                'time' => $task->gameTime,
                'date' => $currentDate,
                'kid_id' => $kid->getId()
            ]);
            
            $doneTaskModel->addDoneTask([
                'task_id' => $task->getId(),
                'date' => $currentDate
            ]);
            
            $kidModel->changeKidTime($kid, $task->gameTime);   
        }
        catch (ValidatorException $e)
        {
            $errors = $e->getErrors();
            $this->request->addSessionParam('errors', $errors);
            $this->redirect('/gaintimeoff/parent/dashboard');
        }
    }
}