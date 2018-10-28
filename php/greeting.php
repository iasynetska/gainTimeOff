<?php 
    session_start();
    if(!isset($_SESSION['name']))
    {
        header('Location: login_parent.php');
        exit();
    }
    
    include_once "lang_config.php";
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
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/style.css"/>
    </head>
    
    <body id="greeting">
        <?php 
            include_once 'header.php';
        ?>
        
        <div class="wrapper  d-flex flex-column" style="min-height: 100vh;">
            <main class="greeting d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                            <div class="message">
                                <p><?php echo sprintf($lang['greeting'], $_SESSION['name'])?></p> <br />

                                <?php
                                    unset($_SESSION['name']);
                                ?>

                                <a href="login_parent.php"><button class="sub-btn"><?php echo $lang['login_submit']?></button></a>
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