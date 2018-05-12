<?php
    session_start();
    include_once "../lang_config.php";
    
    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    $login = filter_input(INPUT_POST, 'login');
    $pass = filter_input(INPUT_POST, 'password');
    $_SESSION['rem_login'] = $login;
    
    $parentDao = new UserParentDao(DbConnection::getPDO());

    $parent = $parentDao->getParentByLogin($login);
    
    if($parent && password_verify($pass, $parent->password))
    {
        $_SESSION['parent'] = $parent;
        header('Location: /gaintimeoff/php/cabinet_parent.php');
    } else {
        $_SESSION['error_login_password'] = $lang['er_login_password'];
        header('Location: /gaintimeoff/php/login_parent.php');
    }
    
?>
