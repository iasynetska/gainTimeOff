<?php
namespace models;

use models\entities\Mark;
use core\DBDriver;
use core\Validator;
use models\entities\UserKid;

class MarkModel extends BaseModel
{
    protected $rules = [        
        'mark' => [
            'isMarkUnique' => TRUE
        ]
    ];
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'marks');
        $this->validator = new Validator($this->rules, $this);
    }
    
    protected function createEntity(array $fields): Mark
    {
        return new Mark(
            $fields['mark'],
            $fields['minutes'],
            $fields['kid_id'],
            $fields['active'],
            $fields['id']
            );
    }
    
    public function getMarksByKid(UserKid $kid): ?array
    {
        $sql = sprintf("SELECT * FROM %s WHERE kid_id=:kid_id", $this->nameTable);
        $marks_result = $this->dbDriver->select($sql, ['kid_id' => $kid->getId()], DBDriver::FETCH_ALL);
        
        if(!$marks_result)
        {
            return NULL;
        }
        
        $arr_marks = [];
        foreach ($marks_result as $result)
        {
            $mark = new Mark(
                $result['mark'],
                $result['minutes'],
                $result['kid_id'],
                $result['active'],
                $result['id']);
            $arr_marks[$result['mark']] = $mark;
        }
        return $arr_marks;
    }
}