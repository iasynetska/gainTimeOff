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
    
    echo "PARENT: ".$parent->name."<br />";
    echo "<hr />";
    echo "DZIECI";
    
    echo "<br /><br />";
    $kidDao = new UserKidDao(DbConnection::getPDO());
    $kid = $kidDao->getKidsByParentId($parent->getId());
    
    if(count($kid) === 0) 
    {
        echo '<a href="./add_kid.php">'.$lang['messenger'].'</a>';
    }
    else
    {
        for($i=0; $i<count($kid); $i++)
        {
            echo "<hr />";
            echo "NAME: ".$kid[$i]->name."<br />";
            echo "TIME TO PLAY: ".$kid[$i]->mins_to_play."<br /><br />";
            if ($kid[$i]->photo === NULL)
            {
                if ($kid[$i]->gender == "girl")
                {
                    echo '<img src="../img/girl.png" alt="girl">';
                }
                else
                {
                    echo '<img src="../img/boy.png" alt="girl">';
                }
            }
            else
            {
                echo '<img src="data:image/jpeg;base64,'.$kid[$i]->photo.'"width="128" height="128"/>';
            }    
            echo "<br /><br />";
        }
    }
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