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
        <title>Log in for parent</title>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/style.css"/>
    </head>

    <body id="login_parent">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.php';
            ?>

            <main class="login d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <form id="formLogin" class="login-parent form" action="./services/do_login_parent.php" method="post" onsubmit="return validateLoginForm('formLogin', 'loginField', 'passwordField')">
                                <div class="form__title">
                                    <?php echo $lang['parent']?>
                                </div>
                                <label>
                                    Login: 
                                    <input id="loginField" class="form__field field-100" type="text" oninput="removeBorder(this.id)" value="<?php
                                        if(isset($_SESSION['rem_login']))
                                        {
                                            echo $_SESSION['rem_login'];
                                            unset($_SESSION['rem_login']);
                                        }
                                    ?>" name="login" autocomplete="on" autofocus/> 
                                </label>
                                <label>
                                    <?php echo $lang['password']?>:
                                    <input id="passwordField" class="form__field field-100" type="password" oninput="removeBorder(this.id)" name="password" />
                                        <?php
                                            if(isset($_SESSION['error_login_password']))
                                            {
                                                echo "<div id='errorMessage'>".$_SESSION['error_login_password']."</div>";
                                                unset($_SESSION['error_login_password']);
                                            }
                                        ?>
                                </label>
                                <input id="subBtn" class="form__btn" type="submit" value="<?php echo $lang['login_submit']?>" />

                                <a class="form__link" href="registration.php"><?php echo $lang['login_parent_link']?></a>
                            </form>
                        </div>
                    </div>  
                </div>
            </main>
        
            <?php 
                include_once 'footer.php';
            ?>
        </div>

        <!-- Main JavaScript-->
        <script src="../js/common.js"></script>
    </body>
</html>