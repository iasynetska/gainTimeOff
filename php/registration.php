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
                            <form id="formRegistration" class="form" action="./services/do_registration.php" method="post" onsubmit="return validateForm(this.id)">
                                <div class="form__title">
                                    <?php echo $lang['registration']?>
                                </div>
                                
                                <!--field Name-->
                                <div class="form__section">
                                    <label for="name" class="markerRequared"><?php echo $lang['name']?>:</label>

                                    <input id="name" class="form__field field-100 requared" type="text" value="<?php
                                        if(isset($_SESSION['tmp_name']))
                                        {
                                            echo $_SESSION['tmp_name'];
                                        }
                                    ?>" name="name" oninput="removeBorder(this.id)" />
                                    <?php 
                                        if(isset($_SESSION['error_name']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_name']."</div>";
                                            unset($_SESSION['error_name']);
                                        }
                                    ?> 
                                </div>
                                
                                <!--field Login-->
                                <div class="form__section">
                                    <label for="login" class="markerRequared">Login:</label>

                                    <input id="login" class="form__field field-100 requared" type="text" value="<?php
                                        if(isset($_SESSION['tmp_login']))
                                        {
                                            echo $_SESSION['tmp_login'];
                                        }
                                        ?>" name="login" oninput="removeBorder(this.id)" /> <br />
                                    <?php
                                        if(isset($_SESSION['error_login']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_login']."</div>";
                                            unset($_SESSION['error_login']);
                                        }
                                        if(isset($_SESSION['error_alnum_login']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_alnum_login']."</div>";
                                            unset($_SESSION['error_alnum_login']);
                                        }
                                        if(isset($_SESSION['error_login_existing']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_login_existing']."</div>";
                                            unset($_SESSION['error_login_existing']);
                                        }
                                    ?>
                                </div>
                                
                                <!--field E-mail-->
                                <div class="form__section">
                                    <label for="email" class="markerRequared">E-mail:</label>

                                    <input id="email" class="form__field field-100 requared" type="email" value="<?php
                                        if(isset($_SESSION['tmp_email']))
                                        {
                                            echo $_SESSION['tmp_email'];
                                        }
                                    ?>" name="email" oninput="removeBorder(this.id)" /> <br />
                                    <?php
                                        if(isset($_SESSION['error_email']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_email']."</div>";
                                            unset($_SESSION['error_email']);
                                        }
                                        if(isset($_SESSION['error_email_existing']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_email_existing']."</div>";
                                            unset($_SESSION['error_email_existing']);
                                        }
                                    ?> 
                                </div>
                                
                                <!--field Password-->
                                <div class="form__section">
                                    <label for="password" class="markerRequared"><?php echo $lang['password']?>:</label>

                                    <input id="password" class="form__field field-100 requared" type="password" value="<?php
                                        if(isset($_SESSION['tmp_password']))
                                        {
                                            echo $_SESSION['tmp_password'];
                                        }
                                    ?>" name="password" oninput="removeBorder(this.id)" /> <br />
                                    <?php
                                        if(isset($_SESSION['error_password']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_password']."</div>";
                                            unset($_SESSION['error_password']);
                                        }
                                    ?> 
                                </div>
                                
                                <!--field Confirm Password-->
                                <div class="form__section">
                                    <label for="confirmPassword" class="markerRequared"><?php echo $lang['confirm_password']?>:</label>

                                    <input id="confirmPassword" class="form__field field-100 requared" type="password" name="confirm_password" oninput="removeBorder(this.id)" />
                                        <?php
                                            if(isset($_SESSION['error_confirm_password']))
                                            {
                                                echo "<div class='form__error'>".$_SESSION['error_confirm_password']."</div>";
                                                unset($_SESSION['error_confirm_password']);
                                            }
                                        ?>
                                </div>
                                
                                <!--field reCaptcha-->
                                <div class="form__section">
                                    <div class="markerRequared"><?php echo $lang['not_robot']?>:</div>
                                    <div id="reCaptcha" class="g-recaptcha" data-sitekey="6Ld-SlUUAAAAAHdMdJ978xjc3D6LFXfsYwYnMEeS" data-callback="selectReCaptcha"></div>
                                    <?php
                                        if(isset($_SESSION['error_robot']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_robot']."</div>";
                                            unset($_SESSION['error_robot']);
                                        }
                                    ?>
                                </div>
                                
                                <span class="attention">*</span><small> - <?php echo $lang['required_field']?></small>
                                
                                <input id="subBtn" class="form__btn" type="submit" value="<?php echo $lang['signup']?>" />
                                
                                <a class="form__link" href="login_parent.php"><?php echo $lang['link_login']?></a>
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
        
        <script src="../libs/jquery/jquery-3.3.1.min.js"></script>
        <script src="../js/common.js"></script>
        <script src="../js/validateForms.js"></script>

        <script>
            window.onload = changeCaptchaSize();
            window.addEventListener("resize", changeCaptchaSize);
        </script>
        
    </body>
</html>