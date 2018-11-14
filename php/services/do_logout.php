<?php

    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    session_start();
    
    
    
    session_unset();
    header('Location: ../welcome.php');