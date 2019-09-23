<?php
namespace models;

use core\ComplitedTaskDBDriver;
use models\entities\ComplitedTask;
use models\entities\UserKid;

class ComplitedTaskModel extends BaseModel
{
    public function __construct(ComplitedTaskDBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'complited_tasks');
    }
    
    protected function createEntity(array $fields): ComplitedTask
    {
        return new ComplitedTask(
            $fields['task_id'],
            $fields['$date'],
            $fields['id']
            );
    }
    
    public function saveComplitedTask(array $params)
    {
        $this->saveItem($params);
    }
    
    public function deleteComplitedTasksByKid(UserKid $kid)
    {
        $this->dbDriver->deleteComplitedTasksByKid($this->nameTable, $kid->getId());
    }
}