<?php
namespace models;

use models\entities\Mark;
use core\DBDriver;
use core\Validator;
use models\entities\UserKid;

class MarkModel extends BaseModel
{
    protected $validator;
    
    protected $rules = [
        'name' => [
            'lengthFrom1to2' => [1, 2],
            'alphanumeric' => TRUE,
            'isMarkUnique' => TRUE
        ],
        
        'gameTime' => [
            'isNumeric' => TRUE,
            'not_empty' => TRUE
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
            $fields['name'],
            $fields['gameTime'],
            $fields['kid_id'],
            $fields['active'],
            $fields['id']
            );
    }
    
    public function getMarksByKid(UserKid $kid): ?array
    {
        $sql = sprintf("SELECT * FROM %s WHERE kid_id=:kid_id ORDER BY name DESC", $this->nameTable);
        $marks_result = $this->dbDriver->select($sql, ['kid_id' => $kid->getId()], DBDriver::FETCH_ALL);
        
        if(!$marks_result)
        {
            return NULL;
        }
        
        $arr_marks = [];
        foreach ($marks_result as $result)
        {
            $mark = new Mark(
                $result['name'],
                $result['gameTime'],
                $result['kid_id'],
                $result['active'],
                $result['id']);
            $arr_marks[$result['name']] = $mark;
        }
        return $arr_marks;
    }
    
    public function isMarkExisting(string $nameColumn, string $valueColumn, int $kid_id): bool
    {
        $sql = sprintf("SELECT * FROM %s WHERE %s =:valueColumn && %s =:valueKidId", $this->nameTable, $nameColumn, 'kid_id');
        $items = $this->dbDriver->select($sql, ['valueColumn'=> $valueColumn, 'valueKidId'=>$kid_id], DBDriver::FETCH_ALL);
        $itemsCount = count($items);
        return $itemsCount > 0;
    }
    
    public function addMark(array $params)
    {
        $this->validator->validate($params);
        
        $this->addItem($params);
    }
}