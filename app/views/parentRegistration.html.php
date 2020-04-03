<main class="register d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col flex-shrink-1">
                <form id="formRegistration" class="form" action="/parent/do-registration" method="post" onsubmit="return validateForm(this.id)">
                    <div class="form__title">
                        <?=$lg_registration?>
                    </div>
                    
                    <!--field Name-->
                    <div class="form__section">
                        <label for="name" class="form__label form__label_required"><?=$lg_name?>:</label>

                        <input id="name" class="form__field form__field_width_100 required" type="text" value="<?=$parent_name?>"
                        	name="name" oninput="deleteBorderStyle(this)" />
                        <div class='form__error'><?=$error_name?></div> 
                    </div>
                    
                    <!--field Login-->
                    <div class="form__section">
                        <label for="login" class="form__label form__label_required"><?=$lg_login?>:</label>

                        <input id="login" class="form__field form__field_width_100 required" type="text" value="<?=$parent_login?>" 
                        	name="login" oninput="deleteBorderStyle(this)" /> <br />
                        <div class='form__error'><?=$error_login?></div>
                    </div>
                    
                    <!--field E-mail-->
                    <div class="form__section">
                        <label for="email" class="form__label form__label_required"><?=$lg_email?>:</label>

                        <input id="email" class="form__field form__field_width_100 required" type="email" value="<?=$parent_email?>" 
                        	name="email" oninput="deleteBorderStyle(this)" /> <br />
                        <div class='form__error'><?=$error_email?></div> 
                    </div>
                    
                    <!--field Password-->
                    <div class="form__section">
                        <label for="password" class="form__label form__label_required"><?=$lg_password?>:</label>

                        <input id="password" class="form__field form__field_width_100 required" type="password"
                        	name="password" oninput="deleteBorderStyle(this)" /> <br />
                        <div class='form__error'><?=$error_password?></div>  
                    </div>
                    
                    <!--field Confirm Password-->
                    <div class="form__section">
                        <label for="confirmPassword" class="form__label form__label_required"><?=$lg_confirm_password?>:</label>

                        <input id="confirmPassword" class="form__field form__field_width_100 required" type="password" name="confirm_password" oninput="deleteBorderStyle(this)" />
                        <div class='form__error'><?=$error_confirm_password?></div> 
                    </div>
                    
                    <!--field reCaptcha-->
                    <div class="form__section">
                        <div class="form__label_required"><?=$lg_not_robot?>:</div>
                        <div id="reCaptcha" class="g-recaptcha" data-sitekey="6Ld-SlUUAAAAAHdMdJ978xjc3D6LFXfsYwYnMEeS" data-callback="selectReCaptcha"></div>
                    	<div class='form__error'><?=$error_reCaptcha?></div> 
                    </div>
                    
                    <span class="form__note">&#42;</span><small> - <?=$lg_required_field?></small>
                    
                    <input id="subBtn" class="form__btn" type="submit" value="<?=$lg_signup?>" />
                    
                    <a class="form__link" href="/parent/login"><?=$lg_link_login?></a>
                </form>
            </div>
        </div>  
    </div>
</main>

