<?php
    require_once './app/core/appConfiguration.php';

    use models\CustomerNumberServices;
    
    //auto-load Classes
    spl_autoload_register(function ($classname) 
        {
            require_once $GLOBALS['_BASE_PATH_'] . str_replace('\\', '/', $classname) . '.php';
        });
    session_start();

    include_once $GLOBALS['_BASE_PATH_'] . 'core/lang_config.php';
    
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
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" type="text/css" href="../../css/style.css"/>
    </head>
    
    <body id="welcome">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once './header.php';
            ?>
        
            <main class="user d-flex align-items-center justify-content-center">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-md-4 align-items-stretch">
                            <div class="user-card" onclick="location.href='./app/views/login_kid.php';">
                                <div class="user-card__title">
                                    <?php echo $lang['kid']?>
                                </div>
                                <div class="user-card__picture">
                                    <picture>
                                        <source media="(max-height: 680px)" srcset="../../img/children_white_small.png">
                                        <img src="../../img/children_white.png" alt="kid">
                                    </picture>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 align-items-stretch">
                            <div class="user-card" onclick="location.href='./app/views/login_parent.php';">
                                <div class="user-card__title">
                                    <?php echo $lang['parent']?>
                                </div>
                                <div class="user-card__picture">
                                    <picture>
                                        <source media="(max-height: 680px)" srcset="../../img/couple_white_small.png">
                                        <img src="../../img/couple_white.png" alt="parent">
                                    </picture>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </main>
            
            <?php
                include_once './footer_with_counter.php';
            ?>
        </div>
    </body>
</html>