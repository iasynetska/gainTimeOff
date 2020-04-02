<?php
namespace models;

use core\CompletedTaskDBDriver;
use models\entities\CompletedTask;
use models\entities\UserKid;

class CompletedTaskModel extends BaseModel
{
    public function __construct(CompletedTaskDBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'completed_tasks');
    }
    
    protected function createEntity(array $fields): CompletedTask
    {
        return new CompletedTask(
            $fields['task_id'],
            $fields['$date'],
            $fields['id']
            );
    }
    
    public function saveCompletedTask(array $params)
    {
        $this->saveItem($params);
    }
    
    public function deleteCompletedTasksByKid(UserKid $kid)
    {
        $this->dbDriver->deleteCompletedTasksByKid($this->nameTable, $kid->getId());
    }
}