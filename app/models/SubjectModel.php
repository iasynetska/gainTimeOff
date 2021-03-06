<?php
namespace models;

use core\DBDriver;
use core\Validator;
use models\entities\Subject;
use models\entities\UserKid;

class SubjectModel extends BaseModel
{
    protected $validator;
    
    protected $rules = [        
        'name' => [
            'lengthFrom2to20' => [2, 20],
            'alphanumeric' => TRUE,
            'isSubjectUnique' => TRUE
        ]
    ];
    
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'subjects');
        $this->validator = new Validator($this->rules, $this);
    }
    
    protected function createEntity(array $fields): Subject
    {
        return new Subject(
            $fields['name'],
            $fields['kid_id'],
            $fields['active'],
            $fields['id']
            );
    }
    
    public function getSubjectsByKid(UserKid $kid): ?array
    {
        $sql = sprintf("SELECT * FROM %s WHERE kid_id=:kid_id ORDER BY name", $this->nameTable);
        $subjects_result = $this->dbDriver->select($sql, ['kid_id' => $kid->getId()], DBDriver::FETCH_ALL);
        
        if(!$subjects_result)
        {
            return NULL;
        }
        
        $arr_subjecs = [];
        foreach ($subjects_result as $result)
        {
            $subject = new Subject(
                $result['name'],
                $result['active'],
                $result['kid_id'],
                $result['id']);
            $arr_subjecs[$result['name']] = $subject;
        }
        return $arr_subjecs;
    }
    
    public function isSubjectExisting(string $nameColumn, string $valueColumn, int $kid_id): bool
    {
        $sql = sprintf("SELECT * FROM %s WHERE %s =:valueColumn && %s =:valueKidId", $this->nameTable, $nameColumn, 'kid_id');
        $items = $this->dbDriver->select($sql, ['valueColumn'=> $valueColumn, 'valueKidId'=>$kid_id], DBDriver::FETCH_ALL);
        $itemsCount = count($items);
        return $itemsCount > 0;
    }
    
    public function saveSubject(array $params)
    {
        $this->validator->validate($params);
        
        $this->saveItem($params);
    }
    
    public function deleteSubjectsByKid(UserKid $kid)
    {
        $paramsCondition = array('kid_id' => $kid->getId());
        $this->deleteItem($paramsCondition);
    }
}