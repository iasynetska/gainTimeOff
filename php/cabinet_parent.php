<?php

    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once 'classes/' . $class . '.php';
    });
    
    session_start();  
    
    //check if authorizeds
    if (!isset($_SESSION['parent']))
    {
            header('Location: welcome.php');
            exit();
    }
    
    $parent = $_SESSION['parent'];
        
    echo "ID: ".$parent->getId()."<br />";
    echo "NAME: ".$parent->name."<br />";
    echo "LOGIN: ".$parent->login."<br />";
    echo "EMAIL: ".$parent->email."<br />";
    echo "PASSWORD: ".$parent->password;    
    
?>
