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
        <title>Registration</title>
        
        <style>
            .error
            {
                color:red;
                margin-bottom: 10px;
            }
	</style>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/style.css"/>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    
    <body id="registration">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.php';
            ?>
        
            <main class="register d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <form class="register-parent form" action="./services/do_registration.php" method="post">
                                <div class="form__title">
                                    <?php echo $lang['registration']?>
                                </div>
                                
                                <!--field Name-->
                                <label>
                                    <?php echo $lang['name']?>: 
                                    <input class="form__field field-100" type="text" value="<?php
                                        if(isset($_SESSION['tmp_name']))
                                        {
                                            echo $_SESSION['tmp_name'];
                                        }
                                    ?>" name="name" /> <br />
                                    <?php 
                                        if(isset($_SESSION['error_name']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_name']."</div>";
                                            unset($_SESSION['error_name']);
                                        }
                                    ?> 
                                </label>
                                
                                <!--field Login-->
                                <label>
                                    Login: 
                                    <input class="form__field field-100" type="text" value="<?php
                                        if(isset($_SESSION['tmp_login']))
                                        {
                                            echo $_SESSION['tmp_login'];
                                        }
                                        ?>" name="login" /> <br />
                                    <?php
                                        if(isset($_SESSION['error_login']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_login']."</div>";
                                            unset($_SESSION['error_login']);
                                        }
                                        if(isset($_SESSION['error_alnum_login']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_alnum_login']."</div>";
                                            unset($_SESSION['error_alnum_login']);
                                        }
                                        if(isset($_SESSION['error_login_existing']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_login_existing']."</div>";
                                            unset($_SESSION['error_login_existing']);
                                        }
                                    ?> 
                                </label>
                                
                                <!--field E-mail-->
                                <label>
                                    E-mail: 
                                    <input class="form__field field-100" type="email" value="<?php
                                        if(isset($_SESSION['tmp_email']))
                                        {
                                            echo $_SESSION['tmp_email'];
                                        }
                                    ?>" name="email" /> <br />
                                    <?php
                                        if(isset($_SESSION['error_email']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_email']."</div>";
                                            unset($_SESSION['error_email']);
                                        }
                                        if(isset($_SESSION['error_email_existing']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_email_existing']."</div>";
                                            unset($_SESSION['error_email_existing']);
                                        }
                                    ?> 
                                </label>
                                
                                <!--field Password-->
                                <label>
                                    <?php echo $lang['password']?>: 
                                    <input class="form__field field-100" type="password" value="<?php
                                        if(isset($_SESSION['tmp_password']))
                                        {
                                            echo $_SESSION['tmp_password'];
                                        }
                                    ?>" name="password" /> <br />
                                    <?php
                                        if(isset($_SESSION['error_password']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_password']."</div>";
                                            unset($_SESSION['error_password']);
                                        }
                                    ?> 
                                </label>
                                
                                <!--field Confirm Password-->
                                <label>
                                    <?php echo $lang['confirm_password']?>: 
                                    <input class="form__field field-100" type="password" name="confirm_password" />
                                        <?php
                                            if(isset($_SESSION['error_confirm_password']))
                                            {
                                                echo "<div class='error'>".$_SESSION['error_confirm_password']."</div>";
                                                unset($_SESSION['error_confirm_password']);
                                            }
                                        ?> 
                                </label>
                                
                                <!--field Captcha-->
                                <div class="g-recaptcha captcha" data-sitekey="6Ld-SlUUAAAAAHdMdJ978xjc3D6LFXfsYwYnMEeS" <!--style="transform:scale(0.82);transform-origin:0 0"--></div>
                                    <?php
                                        if(isset($_SESSION['error_robot']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_robot']."</div>";
                                            unset($_SESSION['error_robot']);
                                        }
                                    ?>
                                
                                <input class="form__btn" type="submit" value="<?php echo $lang['signup']?>" />
                            </form>
                        </div>
                    </div>  
                </div>
            </main>
        
            <?php 
                include_once 'footer.php';
            ?>         
        </div>
        
        <!--Recaptcha-->
        <script src='https://www.google.com/recaptcha/api.js?hl=<?php echo $lang['language']?>'></script>

        <!--jQuery-->
        <script src="../libs/jquery/jquery-3.3.1.min.js"></script>
        
        <script src="../js/common.js"></script>

        
    </body>
</html>