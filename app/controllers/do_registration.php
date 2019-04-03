<?php
   
    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    session_start();
    
    include_once "../lang_config.php";
    
 
    
    $name = filter_input(INPUT_POST, 'name');
    $login = filter_input(INPUT_POST, 'login');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $confirm_password = filter_input(INPUT_POST, 'confirm_password');
    
    
    $error = false;
    
    
    //validation name
    $options = array(
            "options"=>array(
            'regexp'=>'/^[A-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/'
            )
        );
    
    if(empty(filter_var($name)))
    {
        $error = true;
        $_SESSION['error_name'] = $lang['err_empty_name'];
    }else if(!filter_var($name,FILTER_VALIDATE_REGEXP,$options))
    {
        $error = true;
        $_SESSION['error_name'] = $lang['err_name_letters'];
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
    
    
    
    //validation email
    $valid_email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($valid_email, FILTER_VALIDATE_EMAIL)==false) || ($valid_email!=$email))
    {
        $error = true;
        $_SESSION['error_email']=$lang['err_email'];
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
            $_SESSION['error_confirm_password'] = $lang['err_confirm_password'];
        }
    }
    
    
    //validation reCaptcha
    $secret = "6Ld-SlUUAAAAALPqKT2lokYnL76iiTcFOKsiPmhQ";	
    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.filter_input(INPUT_POST, 'g-recaptcha-response'));
    $result = json_decode($check);

    if ($result->success==false)
    {
        $error = true;
        $_SESSION['error_robot'] = $lang['err_robot'];
    }
    
    
    //check errors
    if($error == true) 
    {
        //temporary variables
        $_SESSION['tmp_name'] = $name;
        $_SESSION['tmp_login'] = $login;
        $_SESSION['tmp_email'] = $email;
        $_SESSION['tmp_password'] = $password;
        
        header('Location: ../registration.php');
        exit();
    } 
    else 
    {       
        $parentDao = new UserParentDao(DbConnection::getPDO());
        
        $exist = false;
        

        //check if Login and Email already exist
        if($parentDao->isLoginExisting($login))
        {
            $exist = true;
            $_SESSION['error_login_existing'] = $lang['err_login_existing'];
        }
        
        if($parentDao->isEmailExisting($email))
        {
            $exist = true;
            $_SESSION['error_email_existing'] = $lang['err_email_existing'];
        }
        
        if($exist)
        {
            header('Location: /gaintimeoff/php/registration.php');
            exit();
        }
        else
        {
            //unset temporary variables AND create User
            unset($_SESSION['tmp_name']);
            unset($_SESSION['tmp_login']);
            unset($_SESSION['tmp_email']);
            unset($_SESSION['tmp_password']);
            
            $hash_password = password_hash($password, PASSWORD_DEFAULT); 
            $parent = new UserParent($name, $login, $email, $hash_password);
            $parentDao->createUserParent($parent);

            $_SESSION['name'] = $name;
            header('Location: ../greeting.php');
            exit();
        }
    }
?>