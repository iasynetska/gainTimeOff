<?php 
namespace controllers;

use \Exception;
use core\DBDriver;
use core\DbConnection;
use core\Exceptions\ValidatorException;
use core\TimeConverter;
use core\dto\Message;
use models\TaskModel;
use models\TaskFacade;

class RestTaskController extends RestController
{
    const ACTIVE = 1;
    
    public function doSavingTaskAction()
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
                $TaskModel->saveTask([
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
    
    
    public function saveCompletedTaskAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $taskName = $this->request->getPostParam('taskName');
        $task = $kid->getKidTasks()[$taskName];
        $taskFacade = new TaskFacade();
        
        try
        {
           $taskFacade->saveCompletedTaskAndChangeKidTime($kid, $task);
        }
        catch (Exception $e)
        {
            $this->content = new Message($e->getMessage());
            http_response_code(500);
        }
    }
}