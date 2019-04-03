<?php
     
    //check if Login and Password are passed
//    if(!isset($_POST['login']) || !isset($_POST['password']))
//    {
//        header('Location: /gaintimeoff/php/login_parent.php');
//        exit();
//    }
    namespace controllers;
    use models\UserParentDao;
    use core\DbConnection;
    require_once '../core/appConfiguration.php';
    
    //auto-load Classes
    spl_autoload_register(function ($classname) 
    {
        require_once $GLOBALS['_BASE_PATH_'] . str_replace('\\', '/', $classname) . '.php';
    });
    
    session_start();
    
    include_once $GLOBALS['_BASE_PATH_'] . 'core/lang_config.php';
    
    $login = filter_input(INPUT_POST, 'login');
    $pass = filter_input(INPUT_POST, 'password');
    $_SESSION['rem_login'] = $login;
    
    $parentDao = new UserParentDao(DbConnection::getPDO());

    $parent = $parentDao->getParentByLogin($login);
    
    if($parent && password_verify($pass, $parent->password))
    {
        $_SESSION['parent'] = $parent;
        header('Location: /gaintimeoff/app/views/dashboard_parent_kids.php');
        exit();
    } else {
        $_SESSION['error_login_password'] = $lang['err_login_password'];
        header('Location: /gaintimeoff/app/views/login_parent.php');
        exit();
    }