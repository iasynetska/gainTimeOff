<main class="register d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col flex-shrink-1">
                <form id="formRegistration" class="form" action="../controllers/do_registration.php" method="post" onsubmit="return validateForm(this.id)">
                    <div class="form__title">
                        <?=$lg_registration?>
                    </div>
                    
                    <!--field Name-->
                    <div class="form__section">
                        <label for="name" class="form__label form__label_required"><?=$lg_name?>:</label>

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
                    
                    <!--field Login-->
                    <div class="form__section">
                        <label for="login" class="form__label form__label_required"><?=$lg_login?>:</label>

                        <input id="login" class="form__field form__field_width_100 required" type="text" value="<?php
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
                        <label for="email" class="form__label form__label_required"><?=$lg_email?>:</label>

                        <input id="email" class="form__field form__field_width_100 required" type="email" value="<?php
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
                        <label for="password" class="form__label form__label_required"><?=$lg_password?>:</label>

                        <input id="password" class="form__field form__field_width_100 required" type="password" value="<?php
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
                        <label for="confirmPassword" class="form__label form__label_required"><?=$lg_confirm_password?>:</label>

                        <input id="confirmPassword" class="form__field form__field_width_100 required" type="password" name="confirm_password" oninput="removeBorder(this.id)" />
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
                        <div class="form__label_required"><?=$lg_not_robot?>:</div>
                        <div id="reCaptcha" class="g-recaptcha" data-sitekey="6Ld-SlUUAAAAAHdMdJ978xjc3D6LFXfsYwYnMEeS" data-callback="selectReCaptcha"></div>
                        	<?php
                                if(isset($_SESSION['error_robot']))
                                {
                                    echo "<div class='form__error'>".$_SESSION['error_robot']."</div>";
                                    unset($_SESSION['error_robot']);
                                }
                            ?>
                    </div>
                    
                    <span class="form__note">&#42;</span><small> - <?=$lg_required_field?></small>
                    
                    <input id="subBtn" class="form__btn" type="submit" value="<?=$lg_signup?>" />
                    
                    <a class="form__link" href="/gaintimeoff/parent/login"><?=$lg_link_login?></a>
                </form>
            </div>
        </div>  
    </div>
</main>
