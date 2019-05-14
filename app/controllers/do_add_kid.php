<?php
    namespace controllers;
    use models\UserKidDao;
    use core\DbConnection;
    use models\UserKid;
    require_once '../core/AppConfig.php';
    
    /*auto-load Classes*/
    spl_autoload_register(function ($classname) 
    {
        require_once $GLOBALS['_BASE_PATH_'] . str_replace('\\', '/', $classname) . '.php';
    });
    
    session_start();
    
    include_once $GLOBALS['_BASE_PATH_'] . 'core/lang_config.php';
    
 
    
    $name = filter_input(INPUT_POST, 'name');
    $gender = filter_input(INPUT_POST, 'gender');
    $login = filter_input(INPUT_POST, 'login');
    $password = filter_input(INPUT_POST, 'password');
    $confirm_password = filter_input(INPUT_POST, 'confirm_password');
    $date = filter_input(INPUT_POST, 'date_of_birth');
    
    
    $error = false;
    
    //validation name
    $options = array(
            "options"=>array(
            'regexp'=>'/^[a-zA-Z ]*$/'
            )
        );
    
    if(empty(filter_var($name)))
    {
        $error = true;
        $_SESSION['error_name'] = $lang['err_empty_name'];
    }
    else if(!filter_var($name,FILTER_VALIDATE_REGEXP,$options))
    {
        $error = true;
        $_SESSION['error_name'] = $lang['err_name'];
    }
    
    
    //validation gender
    if(!($gender == 'girl' || $gender == 'boy'))
    {
        $error = true;
        $_SESSION['error_gender'] = $lang['err_gender'];
    }
    
    
    //validation login
    if(strlen($login)<3||strlen($login)>20||empty($login))
    {
        $error = true;
        $_SESSION['error_login'] = $lang['err_login'];
    }
    else if(!ctype_alnum($login))
    {
        $error = true;
        $_SESSION['error_alnum_login'] = $lang['err_alnum_login'];
    }
    
    
    //validation password
    if(strlen($password)<8||strlen($password)>20)
    {
        $error = true;
        $_SESSION['error_password'] = $lang['err_password'];
    }
    else {
        if($password!=$confirm_password)
        {
            $error = true;
            $_SESSION['error_password'] = $lang['err_confirm_password'];
        }
    }
    
    //valida Date of birthday
    if(empty($date))
    {
        $date_of_birth = NULL;
    }
    else
    {
        $date_array = explode("-", $date);
        $year = $date_array[0];
        $month = $date_array[1];
        $day = $date_array[2];
        
        if(checkdate($month, $day, $year))
        {
            $date_of_birth = $date;
        }
        else
        {
            $error = true;
            $_SESSION['error_date'] = $lang['err_date'];
        }
    }
    
    //validation photo
    if($_FILES['photo']['error'] == UPLOAD_ERR_NO_FILE)
    {
        $photo = NULL;
    }
    else
    {
        if($_FILES['photo']['error'] == UPLOAD_ERR_OK)
        {
            $photo_tmp = $_FILES['photo']['tmp_name'];
            $photo_content = file_get_contents($photo_tmp);
            $photo = base64_encode($photo_content);
        }
        else 
       {
            switch($_FILES['photo']['error'])
            {
                case UPLOAD_ERR_INI_SIZE :
                case UPLOAD_ERR_FORM_SIZE :
                    $error = true;
                    $_SESSION['error_photo'] = $lang['err_size'];
                    break;

                case UPLOAD_ERR_PARTIAL :
                    $error = true;
                    $_SESSION['error_photo'] = $lang['err_partially_uploaded'];
                    break;

                case UPLOAD_ERR_NO_TMP_DIR:
                    $error = true;
                    $_SESSION['error_photo'] = $lang['err_tmp_folder'];
                    break;

                case UPLOAD_ERR_CANT_WRITE:
                    $error = true;
                    $_SESSION['error_photo'] = $lang['err_cant_write'];
                    break;

                case UPLOAD_ERR_EXTENSION:
                    $error = true;
                    $_SESSION['error_photo'] = $lang['err_extension_PHP'];

                default :
                    $error = true;
                    $_SESSION['error_photo'] = $lang['err_unknown'];
                    echo "Nieznany typ błędu!";
            }
        }
   }


    
    //check errors
    if($error == true) 
    {
        //temporary variables
        $_SESSION['tmp_name'] = $name;
        $_SESSION['tmp_gender'] = $gender;
        $_SESSION['tmp_login'] = $login;
        $_SESSION['tmp_password'] = $password;
        $_SESSION['tmp_date'] = $date;
        
        header('Location: /gaintimeoff/app/views/add_kid.php');
        exit();
    }
    else 
    {       
        $kidDao = new UserKidDao(DbConnection::getPDO());
        
        $exist = false;
        

        //check if Login already exist
        $parent = $_SESSION['parent'];
        $parent_id = $parent->getId();
        
        if($kidDao->isLoginExisting($login, $parent_id))
        {
            $exist = true;
            $_SESSION['error_login_existing'] = $lang['err_login_existing'];
        }
        
      
        if($exist)
        {
            header('Location: /gaintimeoff/app/views/add_kid.php');
            exit();
        }
        else
        {
            //unset temporary variables AND create User
            unset($_SESSION['tmp_name']);
            unset($_SESSION['tmp_gender']);
            unset($_SESSION['tmp_login']);
            unset($_SESSION['tmp_password']);
            unset($_SESSION['tmp_date']);
            
            
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $kid = new UserKid($name, $gender, $login, $hash_password, $date_of_birth, $photo, $parent_id);
            $kidDao->createUserKid($kid);
            $_SESSION['kid'] = $kid;
            
            $parent->reloadKids();

            header('Location: /gaintimeoff/app/views/dashboard_parent_kids.php');
            exit();
        }
    }