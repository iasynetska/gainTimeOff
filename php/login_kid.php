<?php
    session_start();
    include_once "lang_config.php";
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
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/style.css"/>
    </head>
    
    <body id="login_kid">
        <?php 
            include_once 'header.php';
        ?>
        
        <div class="wrapper  d-flex flex-column" style="min-height: 100vh;">
            <main class="login d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                            <form class="login-parent form" action="login.php" method="post">
                                <div class="form__title">
                                    <?php echo $lang['kid']?>
                                </div>
                                <label>
                                    Login:
                                    <input class="form__field" type="text" name="login" />
                                </label>
                                <label>
                                    <?php echo $lang['password']?>:
                                    <input class="form__field" type="password" name="password" />
                                </label>
                                <input class="form__btn" type="submit" value="<?php echo $lang['login_submit']?>" />
                            </form>
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
