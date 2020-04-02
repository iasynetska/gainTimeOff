<?php
namespace models;

use core\ReceivedMarkDBDriver;
use models\entities\ReceivedMark;
use models\entities\UserKid;

class ReceivedMarkModel extends BaseModel
{
    public function __construct(ReceivedMarkDBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'received_marks');
    }
    
    protected function createEntity(array $fields): ReceivedMark
    {
        return new ReceivedMark(
            $fields['subject_id'],
            $fields['mark_id'],
            $fields['date'],
            $fields['id']
            );
    }
    
    public function saveReceivedMark(array $params)
    {
        $this->saveItem($params);
    }
    
    public function deleteReceivedMarksByKId(UserKid $kid)
    {
        $this->dbDriver->deleteReceivedMarksByKid($this->nameTable, $kid->getId());
    }
}