<?php
namespace models;

use models\entities\UserKid;
use models\entities\User;
use core\DBDriver;
use models\entities\UserParent;

class KidModel extends BaseModel
{
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'kids');
    }
    
    protected function createEntity(array $fields): User
    {
        return new UserKid(
            $fields['name'], 
            $fields['gender'], 
            $fields['login'], 
            $fields['password'], 
            $fields['date_of_birth'], 
            $fields['photo'], 
            $fields['parent_id'], 
            $fields['mins_to_play'], 
            $fields['id']
        );
    }
    
    public function getKidsByParent(UserParent $parent): ?array
    {
        $sql = sprintf("SELECT * FROM %s WHERE parent_id=:parent_id", $this->nameTable);
        $kids_result = $this->dbDriver->select($sql, ['parent_id' => $parent->getId()], DBDriver::FETCH_ALL);
        
        if(!$kids_result)
        {
            return NULL;
        }
        
        $arr_kids = [];
        foreach ($kids_result as $result)
        {
            $kid = new UserKid(
                $result['name'], 
                $result['gender'], 
                $result['login'],
                $result['password'], 
                $result['date_of_birth'], 
                $result['photo'],
                $result['parent_id'], 
                $result['mins_to_play'], 
                $result['id']);
            array_push($arr_kids, $kid);
        }
        return $arr_kids;
    }
}