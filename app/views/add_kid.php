<?php
    require_once '../core/AppConfig.php';
    //auto-load Classes
    spl_autoload_register(function ($classname)
    {
        require_once $GLOBALS['_BASE_PATH_'] . str_replace('\\', '/', $classname) . '.php';
    });
    
    session_start();
    
    include_once $GLOBALS['_BASE_PATH_'] . 'core/lang_config.php';
    
 
    //check if authorised
    if (!isset($_SESSION['parent']))
    {
        header('Location: /gaintimeoff/index.php');
        exit();
    }
    
    $parent = $_SESSION['parent'];
?>


<!DOCTYPE HTML>
<html lang="en">
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Adding kid</title>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../../css/style.css"/>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    
    <body id="add_kid">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.html.php';
            ?>
            
            <main class="dashboard d-flex flex-column flex-wrap">
                <?php 
                    include_once 'top-menu.php';
                ?>
                
                <div class="dashboard-content flex-grow-1 d-flex flex-column">
                    <div class="content-main flex-grow-1 d-flex justify-content-center align-items-center">
                        <form id="formAddingKid" class="adding-kid form" action="../controllers/do_add_kid.php" method="post" enctype = "multipart/form-data" onsubmit="return validateForm(this.id)">
                            <div class="form__title">
                                <?php echo $lang['add_kid']?>
                            </div>
                            
                            <!--field Name-->
                            <div class="form__section">
                                <label for="name" class="form__label form__label_required"><?php echo $lang['name']?>:</label>
                                
                                <input id="name" class="form__field form__field_width_100 required" type="text" value="<?php
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
                            

                            <!--field Gender-->
                            <div class="form__section">
                                <div class="form__label form__label_required"><?php echo $lang['choose_option']?></div>
                                
                                <div id="gender">
                                    <input id="boy" type="radio" name="gender" value="boy" oninput="removeBorder('gender')" /><?php echo $lang['boy']?>
                                    <input id="girl" type="radio" name="gender" value="girl" oninput="removeBorder('gender')" /><?php echo $lang['girl']?><br />
                                    <?php
                                        if(isset($_SESSION['error_gender']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_gender']."</div>";
                                            unset($_SESSION['error_gender']);
                                        }
                                    ?>
                                </div>
                            </div>                            

                            <!--field Login-->
                            <div class="form__section">
                                <label for="login" class="form__label form__label_required">Login:</label>
                                
                                <input id="login" class="form__field form__field_width_100 required" type="text" value="<?php
                                    if(isset($_SESSION['tmp_login']))
                                    {
                                        echo $_SESSION['tmp_login'];
                                    }
                                    ?>" name="login" oninput="removeBorder(this.id)" /><br />
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

                            <!--field Password-->
                            <div class="form__section">
                                
                                <label for="password" class="form__label form__label_required"><?php echo $lang['password']?>:</label>

                                <input id="password" class="form__field form__field_width_100 required" type="password" value="<?php
                                    if(isset($_SESSION['tmp_password']))
                                    {
                                        echo $_SESSION['tmp_password'];
                                    }
                                ?>" name="password" oninput="removeBorder(this.id)" /><br />
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
                                <label for="confirmPassword" class="form__label form__label_required"><?php echo $lang['confirm_password']?>:</label>
                                
                                <input id="confirmPassword" class="form__field form__field_width_100 required" type="password" name="confirm_password" oninput="removeBorder(this.id)" />
                            </div>
                            
                            <!--field Date of birthday-->
                            <div class="form__section">
                                <label for="birthday"><?php echo $lang['date_of_birth']?>:</label>

                                <input id="birthday" class="form__field form__field_width_100" type="date" value="<?php
                                    if(isset($_SESSION['tmp_date']))
                                        {
                                            echo $_SESSION['tmp_date'];
                                        }
                                ?>" name="date_of_birth" oninput="removeBorder(this.id)" /><br />
                                <?php
                                    if(isset($_SESSION['error_date']))
                                    {
                                        echo "<div class='form__error'>".$_SESSION['error_date']."</div>";
                                        unset($_SESSION['error_date']);
                                    }
                                ?>
                            </div>

                            <!--photo-->
                            <div class="form__section">
                                <label for="add-file__real"><?php echo $lang['photo']?>:</label>

                                <div class="form-add-file d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <input id="add-file__real" class="form__field field-100" onchange="addFileName()" type="file" name="photo" hidden="hidden" />
                                        <button id="add-file__btn flex-shrink-0" class="form__btn button" onclick="clickInputFile()" type="button"><?php echo $lang['choose_file']?></button>
                                        <span id="add-file__text" class="form__text">&hellip;</span>
                                    </div>
                                        <img class="add-file__delete" src="../../img/delete_file_32.png" onclick="clearFile()">

                                    <?php
                                        if(isset($_SESSION['error_photo']))
                                        {
                                            echo "<div class='form__error'>".$_SESSION['error_photo']."</div>";
                                            unset($_SESSION['error_photo']);
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <span class="form__note">&#42;</span><small> - <?php echo $lang['required_field']?></small>
                            
                            <input class="form__btn" type="submit" value="<?php echo $lang['save']?>" />
                        </form>
                    </div>
                </div>
            </main>

            <?php 
                include_once 'footer.html.php';
            ?>
        </div>  
        
        
        <!--jQuery-->
        <script src="../../libs/jquery/jquery-3.3.1.min.js"></script>
        <!--JavaScript-->
        <script src="../../js/validateForms.js"></script>
    </body>
</html>