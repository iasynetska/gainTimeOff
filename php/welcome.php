<?php
    //auto-load Classes
    spl_autoload_register(function ($class) 
        {
            require_once './classes/' . $class . '.php';
        });
        
    session_start();
    include_once "lang_config.php";
    
    if(($count = CustomerNumberServices::incrementAndGetVisitorCounter()) == false)
        {
            $count = $lang['unknown'];
        }
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>Welcome</title>
        
        <!-- reset for browsers -->
        <link rel="stylesheet" type="text/css" href="../css/normalize.css"/>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    
    <body id="welcome">
        <?php 
            include_once 'header.php';
        ?>
        
        <div class="wrapper  d-flex flex-column" style="min-height: 100vh;">
            <main class="user d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="user-card" onclick="location.href='login_kid.php';">
                                <div class="user-card__title">
                                    <?php echo $lang['kid']?>
                                </div>
                                <div class="user-card__img">
                                    <img src="../img/children_white.png" alt="kid">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="user-card" onclick="location.href='login_parent.php';">
                                <div class="user-card__title">
                                    <?php echo $lang['parent']?>
                                </div>
                                <div class="user-card__img">
                                    <img src="../img/couple_white.png" alt="parent">
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </main>
            
            <?php
                include_once 'footer_with_counter.php';
            ?>
    </body>
</html>