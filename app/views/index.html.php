<main class="user d-flex align-items-center justify-content-center">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-6 col-md-4 align-items-stretch">
                <div class="user-card" onclick="location.href='./kid/login';">
                    <div class="user-card__title">
                        <?=$lg_kid?>
                    </div>
                    <div class="user-card__picture">
                        <picture>
                            <source media="(max-height: 680px)" srcset="img/children_white_small.png">
                            <img src="img/children_white.png" alt="kid">
                        </picture>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 align-items-stretch">
                <div class="user-card" onclick="location.href='./parent/login';">
                    <div class="user-card__title">
                        <?=$lg_parent?>
                    </div>
                    <div class="user-card__picture">
                        <picture>
                            <source media="(max-height: 680px)" srcset="img/couple_white_small.png">
                            <img src="img/couple_white.png" alt="parent">
                        </picture>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</main>