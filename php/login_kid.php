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
                                    <a class="nav-link english" href="login_kid.php?lang=en"><?php echo $lang['en']?></a>
                                </li>
                                <li>
                                    <div class="nav-slash">|</div>
                                </li>
                                <li>
                                    <a class="nav-link polish" href="login_kid.php?lang=pl"><?php echo $lang['pl']?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        
        <div class="wrapper  d-flex flex-column" style="min-height: 100vh;">
            <main class="login d-flex flex-column flex-grow-1">
                <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                            <form class="login_kid" action="login.php" method="post">
                                <div class="login_title">
                                    <?php echo $lang['kid']?>
                                </div>
                                <label>
                                    Login:
                                    <input class="field" type="text" name="login" />
                                </label>
                                <label>
                                    <?php echo $lang['password']?>:
                                    <input class="field" type="password" name="password" />
                                </label>
                                <input class="sub-btn" type="submit" value="<?php echo $lang['login_submit']?>" />
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

    </body>
</html>
