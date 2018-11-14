<?php
     
    //check if Login and Password are passed
//    if(!isset($_POST['login']) || !isset($_POST['password']))
//    {
//        header('Location: /gaintimeoff/php/login_parent.php');
//        exit();
//    }
    
    //auto-load Classes
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    session_start();
    
    include_once "../lang_config.php";
    
    
    
    $login = filter_input(INPUT_POST, 'login');
    $pass = filter_input(INPUT_POST, 'password');
    $_SESSION['rem_login'] = $login;
    
    $kidDao = new UserKidDao(DbConnection::getPDO());

    $kid = $kidDao->getKidByLogin($login);
    
    if($kid && password_verify($pass, $kid->password))
    {
        $_SESSION['kid'] = $kid;
        header('Location: /gaintimeoff/php/dashboard_kid.php');
    } else {
        $_SESSION['error_login_password'] = $lang['er_login_password'];
        header('Location: /gaintimeoff/php/login_kid.php');
    }