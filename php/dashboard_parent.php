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
    
    echo "PARENT:<br />";
    echo "<hr />";
    echo "ID: ".$parent->getId()."<br />";
    echo "NAME: ".$parent->name."<br />";
    echo "LOGIN: ".$parent->login."<br />";
    echo "EMAIL: ".$parent->email."<br />";
    echo "PASSWORD: ".$parent->password."<br />";  
    
    echo "<br /><br />";
    $kidDao = new UserKidDao(DbConnection::getPDO());
    $kid = $kidDao->getKidsByParentId($parent->getId());
    
    echo "DZIECKO:<br />";
    echo "<hr />";
    echo "ID: ".$kid[0]->getId()."<br />";
    echo "NAME: ".$kid[0]->name."<br />";
    echo "LOGIN: ".$kid[0]->login."<br />";
    echo "PASSWORD: ".$kid[0]->password."<br />";
    echo "Date of Birth: ".$kid[0]->date_of_birth."<br />";
    echo '<img src="data:image/jpeg;base64,'.$kid[0]->photo.'"width="250" height="250"/>';
    
    
    echo "<br /><br />";

    
    echo "DZIECKO:<br />";
    echo "<hr />";
    echo "ID: ".$kid[1]->getId()."<br />";
    echo "NAME: ".$kid[1]->name."<br />";
    echo "LOGIN: ".$kid[1]->login."<br />";
    echo "PASSWORD: ".$kid[1]->password."<br />";
    echo "Date of Birth: ".$kid[1]->date_of_birth."<br />";
    echo '<img src="data:image/jpeg;base64,'.$kid[1]->photo.'"width="250" height="250"/>';
    
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard</title>
    </head>
    <body>
        <br /><br /><a href="dashboard_parent.php?lang=en"><?php echo $lang['en']?></a>
        <a href="dashboard_parent.php?lang=pl"><?php echo $lang['pl']?></a>
        
        <br /><br /><a href="./kids.php"><?php echo $lang['kids']?></a>
        <br /><br /><a href="./services/do_logout_parent.php"><?php echo $lang['logout']?></a>
    </body>
</html>