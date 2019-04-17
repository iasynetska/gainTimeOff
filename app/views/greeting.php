<?php 
    require_once '../core/AppConfig.php';
    session_start();
    if(!isset($_SESSION['name']))
    {
        header('Location: /gaintimeoff/app/views/login_parent.php');
        exit();
    }
    
    include_once $GLOBALS['_BASE_PATH_'] . 'core/lang_config.php';
    
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Greeting</title>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../../css/style.css"/>
    </head>
    
    <body id="greeting">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.php';
            ?>

            <main class="greeting d-flex align-items-center justify-content-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-auto flex-shrink-1">
                            <div class="message">
                                <p><?php echo sprintf($lang['greeting'], $_SESSION['name'])?></p> <br />

                                <?php
                                    unset($_SESSION['name']);
                                ?>

                                <button class="form__btn" onclick="location.href='login_parent.php';"><?php echo $lang['login_submit']?></button>
                            </div>
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