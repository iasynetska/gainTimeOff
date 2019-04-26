<main class="login d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col flex-shrink-1">
                <form id="formLoginKid" class="login-kid form" action="../controllers/do_login_kid.php" method="post" onsubmit="return validateForm(this.id)">
                    <div class="form__title">
                        <?=$lg_kid?>
                    </div>
                    
                    <div class="form__section">
                        <label for="loginField" class="form__label form__label_required">Login:</label>
                        <input id="loginField" class="form__field form__field_width_100 required" type="text" value="<?php
                            if(isset($_SESSION['rem_login']))
                            {
                                echo $_SESSION['rem_login'];
                                unset($_SESSION['rem_login']);
                            }
                        ?>" name="login" oninput="removeBorder(this.id)" autocomplete="on" autofocus/> 
                    </div>
                    
                    <div class="form__section">
                        <label for="passwordField" class="form__label form__label_required"><?=$lg_password?>:</label>
                        <input id="passwordField" class="form__field form__field_width_100 required" type="password" name="password" oninput="removeBorder(this.id)" />
                            <?php
                                if(isset($_SESSION['error_login_password']))
                                {
                                    echo "<div class='form__error'>".$_SESSION['error_login_password']."</div>";
                                    unset($_SESSION['error_login_password']);
                                }
                            ?>
                    </div>
                    
                    <span class="form__note">&#42;</span><small> - <?=$lg_required_field?></small>
                    
                    <input id="subBtn" class="form__btn" type="submit" value="<?=$lg_login_submit?>" />
                </form>
            </div>
        </div>  
    </div>
</main>
        