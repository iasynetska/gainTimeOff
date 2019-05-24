<?php
namespace core;

use core\Exceptions\ValidatorException;
use models\BaseModel;

class Validator
{
    private $rules;
    private $model;
    public $errors = [];
    
    public function __construct(array $rules, BaseModel $model)
    {
        $this->rules = $rules;
        $this->model = $model;
    }
    
    public function validate(array $params)
    {
        foreach ($this->rules as $fieldName => $rules)
        {
            if (isset($rules['not_empty']) && $rules['not_empty'] && empty(trim($params[$fieldName]))) 
            {
                $this->errors[$fieldName][] = 'lg_err_empty';
            }
            
            if(isset($rules['regex']) && $rules['regex'] && !$this->isOnlyLetters($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_letters';
            }
            
            if(isset($rules['lengthFrom3to20']) && !$this->isLengthMatch($params[$fieldName], $rules['lengthFrom3to20']))
            {
                $this->errors[$fieldName][] = 'lg_err_length_3to20';
            }
            
            if(isset($rules['lengthFrom8to20']) && !$this->isLengthMatch($params[$fieldName], $rules['lengthFrom8to20']))
            {
                $this->errors[$fieldName][] = 'lg_err_length_8to20';
            }
            
            if(isset($rules['alphanumeric']) && $rules['alphanumeric'] && !ctype_alnum($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_alnum';
            }
            
            if(isset($rules['emailFormat']) && !$this->isEmailCorrect($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_email';
            }
            
            if(isset($rules['not_robot']) && $rules['not_robot'] && !$this->checkReCaptcha($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_captcha';
            }
        }
        
        if (!isset($this->errors['login']))
        {
            if($this->model->isExisting('login', $params['login']))
            {
                $this->errors['login'][] ='lg_err_login_existing';
            }
        }
        
        if (!isset($this->errors['email']))
        {
            if($this->model->isExisting('email', $params['email']))
            {
                $this->errors['email'][] ='lg_err_email_existing';
            }
        }
        
        if(!empty($this->errors))
        {
            throw new ValidatorException($this->errors);
        }
    }
    
    private function isOnlyLetters($param)
    {
        $options = array(
            'options'=>array(
            'regexp'=>'/^[A-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/'
            )
        );
        return filter_var($param, FILTER_VALIDATE_REGEXP, $options);
    }
    
    private function isLengthMatch($param, $rules)
    {
        $min = $rules[0];
        $max = $rules[1];
        return strlen($param)>$min && strlen($param)<$max;
    }
    
    private function isEmailCorrect($email)
    {
        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL) && $sanitizedEmail===$email;
    }
    
    private function checkReCaptcha($param)
    {
        $secret = file_get_contents(dirname(__DIR__, 1).'/reCaptchaKey.txt');
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$param);
        $result = json_decode($check);
        return $result->success;
    }
}