<?php
namespace models;

use core\DBDriver;
use models\entities\GotMark;

class GotMarkModel extends BaseModel
{
    public function __construct(DBDriver $dbDriver)
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
    
    public function addGotMark(array $params)
    {
        $this->dbDriver->insert($this->nameTable, $params);
    }
}