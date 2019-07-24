<?php 
namespace controllers;

use models\TaskModel;
use core\DBDriver;
use core\DbConnection;
use core\Exceptions\ValidatorException;

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
                    'gameTime' => $task->gameTime,
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
}