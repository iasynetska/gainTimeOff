<?php
namespace models;

use core\DBDriver;
use core\Validator;
use models\entities\User;
use models\entities\UserKid;
use models\entities\UserParent;

class KidModel extends UserModel
{
    protected $validator;
    
    protected $rules = [
        'name' => [
            'lengthFrom2to20' => [2, 20],
            'regex' => TRUE,
            'isNameKidUnique' => TRUE
        ],
        
        'gender' => [
            'selectGender' => TRUE
        ],
        
        'login' => [
            'lengthFrom3to20' => [3, 20],
            'alphanumeric' => TRUE,
            'isLoginUnique' => TRUE
        ],
        
        'password' => [
            'lengthFrom8to20' => [8, 20]
        ],
        
        'date_of_birth' => [
            'dateFormat' => TRUE
        ],
        
        'photo' => [
            'checkFileForCorrectness' => TRUE
        ]
    ];
    
    public function __construct(DBDriver $dbDriver)
    {
        parent::__construct($dbDriver, 'kids');
        $this->validator = new Validator($this->rules, $this);
    }
    
    public function saveKid(array $params)
    {
        $this->validator->validate($params);
        
        $insertParams = $this->prepareInsertParams($params);
        $this->saveItem($insertParams);
    }
    
    public function isKidExisting(string $nameColumn, string $valueColumn, int $parent_id): bool
    {
        $sql = sprintf("SELECT * FROM %s WHERE %s =:valueColumn && %s =:valueParentId", $this->nameTable, $nameColumn, 'parent_id');
        $items = $this->dbDriver->select($sql, ['valueColumn'=> $valueColumn, 'valueParentId'=>$parent_id], DBDriver::FETCH_ALL);
        $itemsCount = count($items);
        return $itemsCount > 0;
    }
    
    private function prepareInsertParams(array $params)
    {
        $insertParams = array(
            'name' => '',
            'gender' => '',
            'login' => '',
            'password' => '',
            'date_of_birth' => '',
            'photo' => '',
            'parent_id' => '',
            'time_to_play' => ''
        );
        $insertParams = array_intersect_key($params, $insertParams);
        $insertParams['password'] = password_hash($insertParams['password'], PASSWORD_DEFAULT);
        
        if(empty($insertParams['date_of_birth']))
        {
            $insertParams['date_of_birth'] = NULL;
        }
        
        if($insertParams['photo']['error'] == UPLOAD_ERR_NO_FILE)
        {
            $insertParams['photo'] = NULL;
        }
        else 
        {
            $photo_tmp = $insertParams['photo']['tmp_name'];
            $photo_content = file_get_contents($photo_tmp);
            $insertParams['photo'] = base64_encode($photo_content);
        }
        
        return $insertParams;
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
            $fields['time_to_play'], 
            $fields['id']
        );
    }
    
    public function getKidsByParent(UserParent $parent): array
    {
        $sql = sprintf("SELECT * FROM %s WHERE parent_id=:parent_id ORDER BY name", $this->nameTable);
        $kids_result = $this->dbDriver->select($sql, ['parent_id' => $parent->getId()], DBDriver::FETCH_ALL);
        
//         if(!$kids_result)
//         {
//             return NULL;
//         }
        
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
                $result['time_to_play'], 
                $result['id']);
            $arr_kids[$result['name']] = $kid;
        }
        return $arr_kids;
    }
    
    public function changeKidTime(UserKid $kid, $gameTime)
    {
        $kidTime = $kid->time_to_play;
        $newTime = $kidTime + $gameTime;
        
        $params = array('time_to_play' => $newTime);
        $paramsCondition = array('id' => $kid->getId());
        
        $this->updateItem($params, $paramsCondition);
        
        $kid->time_to_play = $newTime;
    }
    
    public function deleteKid(UserKid $kid)
    {
        $paramsCondition = array('id' => $kid->getId());
        $this->deleteItem($paramsCondition);
    }
}