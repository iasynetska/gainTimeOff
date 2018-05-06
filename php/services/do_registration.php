<?php
    session_start();
    include_once "../lang_config.php";
    
    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    
    $name = $_POST['name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    //remember the entered data
    $_SESSION['rem_name'] = $name;
    $_SESSION['rem_login'] = $login;
    $_SESSION['rem_email'] = $email;
    $_SESSION['rem_password'] = $password;
            
    $error = false;
    
    
    //validation name
    if(empty($name))
    {
        $error = true;
        $_SESSION['error_empty_name'] = $lang['er_empty_name'];
    }
    
    if((!preg_match("/^[a-zA-Z ]*$/",$name)))
    {
        $error = true;
        $_SESSION['error_name'] = $lang['er_name'];
    }
    
    
    //validation login
    if(strlen($login)<3||strlen($login)>20||empty($login))
    {
        $error = true;
        $_SESSION['error_login'] = $lang['er_login'];
    }
    else 
    {    
        if(ctype_alnum($login)==false)
        {
            $error = true;
            $_SESSION['error_alnum_login'] = $lang['er_alnum_login'];
        }
    }
    
    
    //validation email
    $valid_email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($valid_email, FILTER_VALIDATE_EMAIL)==false) || ($valid_email!=$email))
    {
        $error = true;
        $_SESSION['error_email']=$lang['er_email'];
    }
    
    
    //validation password
    if(strlen($password)<8||strlen($password)>20)
    {
        $error = true;
        $_SESSION['error_password'] = $lang['er_password'];
    }
    else {
        if($password!=$confirm_password)
        {
            $error = true;
            $_SESSION['error_confirm_password'] = $lang['er_confirm_password'];
        }
    }
    
    
    //validation captcha
    $secret = "6Ld-SlUUAAAAALPqKT2lokYnL76iiTcFOKsiPmhQ";	
    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $result = json_decode($check);

    if ($result->success==false)
    {
        $error = true;
        $_SESSION['error_robot'] = $lang['er_robot'];
    }
    
    
    if($error == true) 
    {
        header('Location: /gaintimeoff/php/registration.php');
    } 
    else 
    {
        $_SESSION['name'] = $_POST['name'];
        header('Location: /gaintimeoff/php/greeting.php');
    }
    

//    $parentDao = new UserParentDao(DbConnection::getPDO());
//
//    $parent = new UserParent($_POST['name'], $_POST['login'], $_POST['email'], $_POST['password']);
//
//    $parentDao->createUserParent($parent);
?>