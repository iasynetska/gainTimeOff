<?php

    //auto-load Classes
    spl_autoload_register(function ($class) 
    {
        require_once 'classes/' . $class . '.php';
    });
    
    session_start();
    
    include_once "lang_config.php";
    
    
    //check if authorised
    if (!isset($_SESSION['parent']))
    {
        header('Location: welcome.php');
        exit();
    }  
    
    $parent = $_SESSION['parent'];
    $kidDao = new UserKidDao(DbConnection::getPDO());
    $kid = $kidDao->getKidsByParentId($parent->getId());
        
    echo "ID: ".$parent->getId()."<br />";
    echo "NAME: ".$parent->name."<br />";
    echo "LOGIN: ".$parent->login."<br />";
    echo "EMAIL: ".$parent->email."<br />";
    echo "PASSWORD: ".$parent->password."<br /><br />";  
    
    echo "NAME: ".$kid[0]->name."<br />";
    echo "LOGIN: ".$kid[0]->login."<br />";
    echo "PASSWORD: ".$kid[0]->password."<br />";
    echo "Date of Birth: ".$kid[0]->date_of_birth."<br />";
    print "Photo: ".$kid[0]->photo."<br />";
    echo "Parent Id: ".$kid[0]->parent_id."<br />";
    
?>