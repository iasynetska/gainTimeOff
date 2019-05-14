<?php
namespace models;

use models\entities\UserParent;
use models\entities\User;
use core\DBDriver;

class ParentModel extends BaseModel
{
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'parents');
    }
    
    protected function createEntity(array $fields): User
    {
        return new UserParent(
            $fields['name'],
            $fields['login'],
            $fields['email'],
            $fields['password'],
            $fields['id']
            );        
    }
}
    


//     public function getKids(): array
//     {
//         if(!isset($this->kids))
//         {
//             $userKidDao = new UserKidDao(DbConnection::getPDO());

//             $arr_kids = $userKidDao->getKidsByParent($this);

//             if(empty($arr_kids))
//             {
//                 $this->kids = $arr_kids;
//             }
//             else
//             {
//                 foreach($arr_kids as $kid)
//                 {
//                     $this->kids[$kid->name] = $kid;
//                 }
//             }

//         }

//         return $this->kids;
//     }


//     public function reloadKids()
//     {
//         unset($this->kids);
//     }
