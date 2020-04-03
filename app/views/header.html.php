<header class="header flex-shrink-0">
    <nav class="header-nav top-nav">
        <div class="container-fluid">
            <div class="row">
                <div class="col top-nav__logo d-flex align-items-center">
                    <a href="/">GainTimeOff</a>
                </div>
                <div class="col">
                    <ul class="top-nav__list d-flex justify-content-end">
                        <li class="top-nav__item">
                            <a class="top-nav__link" id="<?= $langActive === 'en'?'link_active':''?>" href="<?=$enLink?>"><?=$lg_en?></a>
                        </li>
                        <li class="top-nav__item">
                            <div class="top-nav__text">&#124;</div>
                        </li>
                        <li class="top-nav__item">
                            <a class="top-nav__link" id="<?= $langActive === 'pl'?'link_active':''?>" href="<?=$plLink?>"><?=$lg_pl?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>