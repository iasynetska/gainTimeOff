<?php
    require_once '../core/appConfiguration.php';
    //auto-load Classes
    spl_autoload_register(function ($classname) 
    {
        require_once $GLOBALS['_BASE_PATH_'] . str_replace('\\', '/', $classname) . '.php';
    });
    
    session_start();
    include_once $GLOBALS['_BASE_PATH_'] . 'core/lang_config.php';
    
    
    
    //check if authorised
    if (!isset($_SESSION['kid']))
    {
        header('Location: index.php');
        exit();
    }         
    
    $kid = $_SESSION['kid'];
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Log in for kid</title>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../../css/style.css"/>
    </head>
    
    <body id="dashboard_kid">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.php';
            ?>
        
            <main class="dashboard-content d-flex flex-column flex-grow-1">
                <div class="content-header">
                    <div class="content-header__logout">
                        <?php
                            echo "<div class='logout-text'>".$lang['hello'].$kid->name."</div>";
                            echo"<div class='logout-link'><a href='../controllers/do_logout.php'>".$lang['logout']."</a></div>";
                        ?>
                    </div>
                </div>
                <div class="content-main flex-grow-1 d-flex justify-content-center align-items-center">
                    <div class="content-info">
                        <div class="form__title"><?php echo $lang['your_time'];?></div>
                        <div class="content-info__time">
                            <?php echo $kid->mins_to_play;?>
                        </div>
                    </div>
                </div>
            </main>

            <?php 
                include_once 'footer.php';
            ?>
        </div>

    </body>
</html>