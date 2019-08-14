<?php
namespace models;

use models\entities\DoneTask;
use core\DBDriver;
use core\Validator;

class DoneTaskModel extends BaseModel
{    
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'done_tasks');
    }
    
    protected function createEntity(array $fields): DoneTask
    {
        return new DoneTask(
            $fields['task_id'],
            $fields['$date'],
            $fields['id']
            );
    }
    
    public function addDoneTask(array $params)
    {        
        $this->dbDriver->insert('done_tasks', $params);
    }
}