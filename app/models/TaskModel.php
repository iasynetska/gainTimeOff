<?php
namespace models;

use models\entities\Task;
use core\DBDriver;
use core\Validator;
use models\entities\UserKid;

class TaskModel extends BaseModel
{
    protected $rules = [        
        'name' => [
            'lengthFrom2to20' => [2, 20],
            'alphanumeric' => TRUE,
            'isTaskUnique' => TRUE
        ],
        
        'gameTime' => [
            'timeFormat' => TRUE,
            'not_empty' => TRUE
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
            $fields['name'],
            $fields['gameTime'],
            $fields['kid_id'],
            $fields['active'],
            $fields['id']
            );
    }
    
    public function getTasksByKid(UserKid $kid): ?array
    {
        $sql = sprintf("SELECT * FROM %s WHERE kid_id=:kid_id ORDER BY name", $this->nameTable);
        $tasks_result = $this->dbDriver->select($sql, ['kid_id' => $kid->getId()], DBDriver::FETCH_ALL);
        
        if(!$tasks_result)
        {
            return NULL;
        }
        
        $arr_tasks = [];
        foreach ($tasks_result as $result)
        {
            $task = new Task(
                $result['name'],
                $result['gameTime'],
                $result['kid_id'],
                $result['active'],
                $result['id']);
            $arr_tasks[$result['name']] = $task;
        }
        return $arr_tasks;
    }
    
    public function isTaskExisting(string $nameColumn, string $valueColumn, int $kid_id): bool
    {
        $sql = sprintf("SELECT * FROM %s WHERE %s =:valueColumn && %s =:valueKidId", $this->nameTable, $nameColumn, 'kid_id');
        $items = $this->dbDriver->select($sql, ['valueColumn'=> $valueColumn, 'valueKidId'=>$kid_id], DBDriver::FETCH_ALL);
        $itemsCount = count($items);
        return $itemsCount > 0;
    }
    
    public function addTask(array $params)
    {
        $this->validator->validate($params);
        
        $this->addItem($params);
    }
}