<?php
namespace models;

use models\entities\TimeToPlay;
use core\DBDriver;

class TimeToPlayModel extends BaseModel
{    
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'time_to_play');
    }
    
    protected function createEntity(array $fields): TimeToPlay
    {
        return new TimeToPlay(
            $fields['time'],
            $fields['$date'],
            $fields['kid_id'],
            $fields['id']
            );
    }
    
    public function addTime(array $params)
    {
        $this->addItem($params);
    }
}