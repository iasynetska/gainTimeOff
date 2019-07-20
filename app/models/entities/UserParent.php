<?php
namespace models\entities;

use models\KidModel;
use core\DBDriver;
use core\DbConnection;

class UserParent extends User
{
    public $email;
    private $kids;
    
    public function __construct
    (
        string $name,
        string $login,
        string $email,
        string $password,
        int $id=NULL
    ){
        parent::__construct($name, $login, $password, $id);
        
        $this->email = $email;
    }
    
    public function getKids(): ?array
    {
        if(!isset($this->kids))
        {
            $userKidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
            $arr_kids = $userKidModel->getKidsByParent($this);
            
            if(empty($arr_kids))
            {
                $this->kids = $arr_kids;
            }
            else
            {
                foreach($arr_kids as $kid)
                {
                    $this->kids[$kid->name] = $kid;
                }
            }
            
        }
        
        return $this->kids;
    }
    
    public function resetKids()
    {
        unset($this->kids);
    }
}