<main class="login d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col flex-shrink-1">
                <form id="formLoginKid" class="login-kid form" action="/gaintimeoff/kid/do-login" method="post" onsubmit="return validateForm(this.id)">
                    <div class="form__title">
                        <?=$lg_kid?>
                    </div>
                    
                    <div class="form__section">
                        <label for="loginField" class="form__label form__label_required"><?=$lg_login?></label>
                        <input id="loginField" class="form__field form__field_width_100 required" type="text" value="<?=$kid_login?>" 
                        	name="login" oninput="deleteBorderStyle(this)" autocomplete="on" autofocus/> 
                    </div>
                    
                    <div class="form__section">
                        <label for="passwordField" class="form__label form__label_required"><?=$lg_password?>:</label>
                        <input id="passwordField" class="form__field form__field_width_100 required" type="password" name="password" oninput="deleteBorderStyle(this)" />
                    	<div class='form__error'><?=$lg_error?></div>
                    </div>
                    
                    <span class="form__note">&#42;</span><small> - <?=$lg_required_field?></small>
                    
                    <input id="subBtn" class="form__btn" type="submit" value="<?=$lg_login_submit?>" />
                </form>
            </div>
        </div>  
    </div>
</main>
        