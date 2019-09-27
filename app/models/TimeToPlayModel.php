<?php
namespace models;

use core\DBDriver;
use core\Validator;
use models\entities\TimeToPlay;
use models\entities\UserKid;

class TimeToPlayModel extends BaseModel
{    
    protected $validator;
    
    protected $rules = [        
        'time' => [
            'isNumeric' => TRUE,
            'not_empty' => TRUE
        ]
    ];
    
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'time_to_play');
        $this->validator = new Validator($this->rules, $this);
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
        $this->validator->validate($params);
        $this->saveItem($params);
    }
    
    public function deleteTimeToPlayByKid(UserKid $kid)
    {
        $paramsCondition = array('kid_id' => $kid->getId());
        $this->deleteItem($paramsCondition);
    }
}