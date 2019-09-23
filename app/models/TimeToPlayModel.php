<?php
namespace models;

use core\DBDriver;
use models\entities\TimeToPlay;
use models\entities\UserKid;

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
    
    public function saveTime(array $params)
    {
        $this->saveItem($params);
    }
    
    public function deleteTimeToPlayByKid(UserKid $kid)
    {
        $paramsCondition = array('kid_id' => $kid->getId());
        $this->deleteItem($paramsCondition);
    }
}