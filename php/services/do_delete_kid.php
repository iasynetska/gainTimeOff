<?php

    //auto-load Classes
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    session_start();
    
    include_once "../lang_config.php";
    
    
    
    //check if authorised
    if (!isset($_SESSION['parent']))
    {
        header('Location: ../welcome.php');
        exit();
    }         
    
    $parent = $_SESSION['parent'];
    $parent_id = $parent->getId();
    $kidName = filter_input(INPUT_GET, 'name');
    
    $kidDao = new UserKidDao(DbConnection::getPDO());
    
    $kidDao->deleteUserKid($parent_id, $kidName);
    
    $parent->reloadKids();
    
    echo $lang['delete_profile']." ".$kidName." ".$lang['delete_alert'];