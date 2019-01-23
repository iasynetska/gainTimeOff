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
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.php';
            ?>
        
            <main class="login d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                            <form id="formLoginKid" class="login-kid form" action="./services/do_login_kid.php" method="post" onsubmit="return validateForm(this.id)">
                                <div class="form__title">
                                    <?php echo $lang['kid']?>
                                </div>
                                
                                <div class="form__sectin">
                                    <label for="loginField" class="markerRequared">Login:</label>
                                    <input id="loginField" class="form__field field-100 requared" type="text" value="<?php
                                        if(isset($_SESSION['rem_login']))
                                        {
                                            echo $_SESSION['rem_login'];
                                            unset($_SESSION['rem_login']);
                                        }
                                    ?>" name="login" oninput="removeBorder(this.id)" autocomplete="on" autofocus/> 
                                </div>
                                
                                <div class="form__sectin">
                                    <label for="passwordField" class="markerRequared"><?php echo $lang['password']?>:</label>
                                    <input id="passwordField" class="form__field field-100 requared" type="password" name="password" oninput="removeBorder(this.id)" />
                                        <?php
                                            if(isset($_SESSION['error_login_password']))
                                            {
                                                echo "<div class='form__error'>".$_SESSION['error_login_password']."</div>";
                                                unset($_SESSION['error_login_password']);
                                            }
                                        ?>
                                </div>
                                
                                <span class="attention">*</span><small> - <?php echo $lang['required_field']?></small>
                                
                                <input id="subBtn" class="form__btn" type="submit" value="<?php echo $lang['login_submit']?>" />
                            </form>
                        </div>
                    </div>  
                </div>
            </main>

            <?php 
                include_once 'footer.php';
            ?>
        </div>
        
        
        <!--jQuery-->
        <script src="../libs/jquery/jquery-3.3.1.min.js"></script>
        <!--JavaScript-->
        <script src="../js/validateForms.js"></script>

    </body>
</html>
