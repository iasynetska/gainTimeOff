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
        
        <style>
            .error
            {
                color:red;
                margin-bottom: 10px;
            }
	</style>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Fonts Google Almendra-->
        <link href="https://fonts.googleapis.com/css?family=Almendra:400,700&amp;subset=latin-ext" rel="stylesheet">
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/main.css"/>
    </head>
    
    <body>
        <header class="header">
            <nav class="top-nav">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col top-nav_logo">
                            <a href="welcome.php">TimeToGain</a>
                        </div>
                        <div class="col">
                            <ul class="top-nav_lang justify-content-end">
                                <li>
                                    <a class="nav-link english" href="registration.php?lang=en"><?php echo $lang['en']?></a>
                                </li>
                                <li>
                                    <div class="nav-slash">|</div>
                                </li>
                                <li>
                                    <a class="nav-link polish" href="registration.php?lang=pl"><?php echo $lang['pl']?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        
        <div class="wrapper  d-flex flex-column" style="min-height: 100vh;">
            <main class="register d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                            <form class="register_parent" action="./services/do_registration.php" method="post">
                                <div class="register_title">
                                    <?php echo $lang['registration']?>
                                </div>
                                
                                <!--field Name-->
                                <label>
                                    <?php echo $lang['name']?>: 
                                    <input class="field" type="text" value="<?php
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
                                    <input class="field" type="text" value="<?php
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
                                    <input class="field" type="email" value="<?php
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
                                    <input class="field" type="password" value="<?php
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
                                    <?php echo $lang['confirm_password']?>:: 
                                    <input class="field" type="password" name="confirm_password" />
                                        <?php
                                            if(isset($_SESSION['error_confirm_password']))
                                            {
                                                echo "<div class='error'>".$_SESSION['error_confirm_password']."</div>";
                                                unset($_SESSION['error_confirm_password']);
                                            }
                                        ?> 
                                </label>
                                
                                <!--field Captcha-->
                                <div class="g-recaptcha captcha" data-sitekey="6Ld-SlUUAAAAAHdMdJ978xjc3D6LFXfsYwYnMEeS" style="transform:scale(0.82);transform-origin:0 0"></div>
                                    <?php
                                        if(isset($_SESSION['error_robot']))
                                        {
                                            echo "<div class='error'>".$_SESSION['error_robot']."</div>";
                                            unset($_SESSION['error_robot']);
                                        }
                                    ?>
                                
                                <input class="sub-btn" type="submit" value="<?php echo $lang['signup']?>" />
                            </form>
                        </div>
                    </div>  
                </div>
            </main>
        
            <footer class="footer">
                <div class="container">
                    <div class="copy">
                        <p>&copy;2018 Viktoriia Iasynetska</p>
                    </div>
                </div>
            </footer>
    </div>
        
    <script src='https://www.google.com/recaptcha/api.js?hl=<?php echo $lang['language']?>'></script>
        
    </body>
</html>