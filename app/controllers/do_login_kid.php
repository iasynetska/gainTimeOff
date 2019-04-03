<?php

namespace controllers;
use models\UserKidDao;
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

$kidDao = new UserKidDao(DbConnection::getPDO());

$kid = $kidDao->getKidByLogin($login);

if($kid && password_verify($pass, $kid->password))
{
    $_SESSION['kid'] = $kid;
    header('Location: /gaintimeoff/app/views/dashboard_kid.php');
    exit();
} else {
    $_SESSION['error_login_password'] = $lang['err_login_password'];
    header('Location: /gaintimeoff/app/views/login_kid.php');
    exit();
}