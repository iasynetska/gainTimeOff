<?php
namespace models;

use models\entities\UserParent;
use models\entities\User;
use core\DBDriver;
use core\Validator;

class ParentModel extends UserModel
{
    protected $rules = [
        'name' => [
            'lengthFrom2to20' => [2, 20],
            'regex' => TRUE
        ],
        
        'login' => [
            'lengthFrom3to20' => [3, 20],
            'alphanumeric' => TRUE,
            'isLoginUnique' => TRUE
        ],
        
        'email' => [
            'emailFormat' => TRUE,
            'isEmailUnique' => TRUE
        ],
        
        'password' => [
            'lengthFrom8to20' => [8, 20]
        ],
        
        'g-recaptcha-response' => [
            'not_robot' => TRUE
        ]
    ];
    
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'parents');
        $this->validator = new Validator($this->rules, $this);
    }
    
    public function addParent(array $params)
    {
        $this->validator->validate($params);

        $insertParams = $this->prepareInsertParams($params);
        $this->addItem($insertParams);
    }
    
    private function prepareInsertParams(array $params)
    {
        $insertParams = array(
            'name' => '',
            'login' => '',
            'email' => '',
            'password' => '',
        );
        $insertParams = array_intersect_key($params, $insertParams);
        $insertParams['password'] = password_hash($insertParams['password'], PASSWORD_DEFAULT);
        return $insertParams;
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
