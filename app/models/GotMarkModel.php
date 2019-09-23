<?php
namespace models;

use core\GotMarkDBDriver;
use models\entities\GotMark;
use models\entities\UserKid;

class GotMarkModel extends BaseModel
{
    public function __construct(GotMarkDBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'got_marks');
    }
    
    protected function createEntity(array $fields): GotMark
    {
        return new GotMark(
            $fields['subject_id'],
            $fields['mark_id'],
            $fields['$date'],
            $fields['id']
            );
    }
    
    public function saveGotMark(array $params)
    {
        $this->saveItem($params);
    }
    
    public function deleteGotMarksByKId(UserKid $kid)
    {
        $this->dbDriver->deleteGotMarksByKid($this->nameTable, $kid->getId());
    }
}