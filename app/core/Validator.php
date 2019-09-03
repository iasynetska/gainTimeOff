<?php
namespace core;

use core\Exceptions\ValidatorException;
use models\BaseModel;

class Validator
{
    private $rules;
    private $model;
    public $errors = [];
    public $photoFile = false;
    
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
            
            if(isset($rules['isSubjectUnique']) && $rules['isSubjectUnique'] && !isset($this->errors['subject']))
            {
                if($this->model->isSubjectExisting('name', $params[$fieldName], $params['kid_id']))
                {
                    $this->errors[$fieldName][] ='lg_err_el_existing';
                }
            }
            
            if(isset($rules['isMarkUnique']) && $rules['isMarkUnique'] && !isset($this->errors['mark']))
            {
                if($this->model->isMarkExisting('name', $params[$fieldName], $params['kid_id']))
                {
                    $this->errors[$fieldName][] ='lg_err_el_existing';
                }
            }
            
            if(isset($rules['isTaskUnique']) && $rules['isTaskUnique'] && !isset($this->errors['task']))
            {
                if($this->model->isTaskExisting('name', $params[$fieldName], $params['kid_id']))
                {
                    $this->errors[$fieldName][] ='lg_err_el_existing';
                }
            }
            
            if(isset($rules['isNameKidUnique']) && $rules['isNameKidUnique'] && !isset($this->errors['name']))
            {
                if($this->model->isKidExisting('name', $params[$fieldName], $params['parent_id']))
                {
                    $this->errors[$fieldName][] ='lg_err_name_existing';
                }
            }
            
            if(isset($rules['selectGender']) && $rules['selectGender'] && !($params[$fieldName]==='girl' || $params[$fieldName]==='boy'))
            {
                $this->errors[$fieldName][] = 'lg_err_empty';
            }
            
            if(isset($rules['lengthFrom1to2']) && !$this->isLengthMatch($params[$fieldName], $rules['lengthFrom1to2']))
            {
                $this->errors[$fieldName][] = 'lg_err_length_1to2';
            }
            
            if(isset($rules['lengthFrom2to20']) && !$this->isLengthMatch($params[$fieldName], $rules['lengthFrom2to20']))
            {
                $this->errors[$fieldName][] = 'lg_err_length_2to20';
            }
            
            if(isset($rules['lengthFrom3to20']) && !$this->isLengthMatch($params[$fieldName], $rules['lengthFrom3to20']))
            {
                $this->errors[$fieldName][] = 'lg_err_length_3to20';
            }
            
            if(isset($rules['lengthFrom8to20']) && !$this->isLengthMatch($params[$fieldName], $rules['lengthFrom8to20']))
            {
                $this->errors[$fieldName][] = 'lg_err_length_8to20';
            }
            
            if(isset($rules['isNumeric']) && $rules['isNumeric'] && !is_numeric($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_num';
            }
            
            if(isset($rules['alphanumeric']) && $rules['alphanumeric'] && !ctype_alnum(str_replace(' ','',$params[$fieldName])))
            {
                $this->errors[$fieldName][] = 'lg_err_alnum';
            }
            
            if(isset($rules['isLoginUnique']) && $rules['isLoginUnique'] && !isset($this->errors['login']))
            {
                if($this->model->isExisting('login', $params[$fieldName]))
                {
                    $this->errors[$fieldName][] ='lg_err_login_existing';
                }
            }
            
            if(isset($rules['emailFormat']) && !$this->isEmailCorrect($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_email';
            }
            
            if(isset($rules['isEmailUnique']) && $rules['isEmailUnique'] && !isset($this->errors['email']))
            {
                if($this->model->isExisting('email', $params[$fieldName]))
                {
                    $this->errors[$fieldName][] ='lg_err_email_existing';
                }
            }
            
            if(isset($rules['not_robot']) && $rules['not_robot'] && !$this->checkReCaptcha($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_captcha';
            }
            
            if(isset($rules['dateFormat']) && $rules['dateFormat'] && !$this->isDateCorrect($params[$fieldName]))
            {
                $this->errors[$fieldName][] = 'lg_err_date';
            }
            
            if(isset($rules['checkFileForCorrectness']) && $rules['checkFileForCorrectness'] && $params[$fieldName]['error'] == UPLOAD_ERR_OK)
            {
                switch($params[$fieldName]['error'])
                {
                    case UPLOAD_ERR_INI_SIZE :
                    case UPLOAD_ERR_FORM_SIZE :
                        $this->errors[$fieldName] = 'lg_err_size';
                        break;
                        
                    case UPLOAD_ERR_PARTIAL :
                        $this->errors[$fieldName] = 'lg_err_partially_uploaded';
                        break;
                        
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $this->errors[$fieldName] = 'lg_err_tmp_folder';
                        break;
                        
                    case UPLOAD_ERR_CANT_WRITE:
                        $this->errors[$fieldName] = 'lg_err_cant_write';
                        break;
                        
                    case UPLOAD_ERR_EXTENSION:
                        $this->errors[$fieldName] = 'lg_err_extension_PHP';
                }
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
            'regexp'=>'/^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/'
            )
        );
        return filter_var($param, FILTER_VALIDATE_REGEXP, $options);
    }
    
    private function isLengthMatch($param, $rules)
    {
        $min = $rules[0];
        $max = $rules[1];
        return strlen($param)>=$min && strlen($param)<=$max;
    }
    
    private function isEmailCorrect($email)
    {
        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL) && $sanitizedEmail===$email;
    }
    
//     private function isDateTimeCorrect($param)
//     {
//         $options = array(
//             'options'=>array(
//                 'regexp'=>'/^([12]\d{3})-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/'
//             )
//         );
//         return filter_var($param, FILTER_VALIDATE_REGEXP, $options);
//     }
    
    private function checkReCaptcha($param)
    {
        $secret = file_get_contents(dirname(__DIR__, 1).'/reCaptchaKey.txt');
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$param);
        $result = json_decode($check);
        return $result->success;
    }
    
    private function isDateCorrect($date)
    {
        if(!empty($date))
        {
            $date_array = explode("-", $date);
            $year = $date_array[0];
            $month = $date_array[1];
            $day = $date_array[2];
            
            return checkdate($month, $day, $year);
        }
        return TRUE;
    }
}