<main class="greeting d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto flex-shrink-1">
                <div class="message">
                    <p><?=sprintf($lg_greeting, $parentName)?></p> <br />
                    <a class="form__link" href="/parent/login"><?=$lg_login_form?></a>
                </div>
            </div>
        </div>
    </div>
</main>