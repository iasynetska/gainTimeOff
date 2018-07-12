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
        
        <!--Fonts Google Almendra-->
        <link href="https://fonts.googleapis.com/css?family=Almendra:400,700&amp;subset=latin-ext" rel="stylesheet">
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/main.css"/>
    </head>
    
    <body>
        <header>
            <nav class="top-nav">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col top-nav_logo">
                            <a href="welcome.php">TimeToGain</a>
                        </div>
                        <div class="col">
                            <ul class="top-nav_lang justify-content-end">
                                <li>
                                    <a class="nav-link english" href="welcome.php?lang=en"><?php echo $lang['en']?></a>
                                </li>
                                <li>
                                    <div class="nav-slash">|</div>
                                </li>
                                <li>
                                    <a class="nav-link polish" href="welcome.php?lang=pl"><?php echo $lang['pl']?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        
        <section class="login">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-auto kid">
                        <form action="login.php" method="post">
                            Login: <br /> <input type="text" name="login" /> <br />
                            <?php echo $lang['password']?>: <br /> <input type="password" name="password" /> <br /><br />
                            <input type="submit" value="<?php echo $lang['login_submit']?>" /><br /><br />
                        </form>
                    </div>
                </div>  
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="copy">
                    <p>&copy;2018 Viktoriia Iasynetska</p>
                </div>
            </div>
        </footer>
        
        <!--Bootstrap core Javascript-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.slim.min.js"><\/script>')</script>
    </body>
</html>
