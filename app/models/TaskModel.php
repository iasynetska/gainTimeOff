<?php
namespace models;

use models\entities\Task;
use core\DBDriver;
use core\Validator;
use models\entities\UserKid;

class TaskModel extends BaseModel
{
    protected $rules = [        
        'task' => [
            'isTaskUnique' => TRUE
        ]
    ];
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'tasks');
        $this->validator = new Validator($this->rules, $this);
    }
    
    protected function createEntity(array $fields): Task
    {
        return new Task(
            $fields['task'],
            $fields['minutes'],
            $fields['kid_id'],
            $fields['active'],
            $fields['id']
            );
    }
    
    public function getTasksByKid(UserKid $kid): ?array
    {
        $sql = sprintf("SELECT * FROM %s WHERE kid_id=:kid_id", $this->nameTable);
        $tasks_result = $this->dbDriver->select($sql, ['kid_id' => $kid->getId()], DBDriver::FETCH_ALL);
        
        if(!$tasks_result)
        {
            return NULL;
        }
        
        $arr_tasks = [];
        foreach ($tasks_result as $result)
        {
            $task = new Task(
                $result['task'],
                $result['minutes'],
                $result['kid_id'],
                $result['active'],
                $result['id']);
            $arr_tasks[$result['task']] = $task;
        }
        return $arr_tasks;
    }
}