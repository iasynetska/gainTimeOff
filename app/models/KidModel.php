<?php
namespace models;

use models\entities\Kid;
use models\entities\User;
use core\DBDriver;

class KidModel extends BaseModel
{
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'kids');
    }
    
    protected function createEntity(array $fields): User
    {
        return new Kid(
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
}