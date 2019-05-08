<main class="dashboard-content d-flex flex-column flex-grow-1">
    <div class="content-header">
        <div class="content-header__logout">
        	<div class='logout-text'><?=$helloKid?></div>
        	<div class='logout-link'><a href='/gaintimeoff/kid/logout'><?=$lg_logout?></a></div>
        </div>
    </div>
    <div class="content-main flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="content-info">
            <div class="form__title"><?=$lg_time_to_play?></div>
            <div class="content-info__time">
                <?=$kidMins?>
            </div>
        </div>
    </div>
</main>