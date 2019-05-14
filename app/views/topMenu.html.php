<div class="top-menu d-flex flex-row justify-content-between align-items-center">
    <input id="top-menu__toggle" type="checkbox" />
    <label class="top-menu__wrap-button" for="top-menu__toggle">
            <div class="top-menu__button"></div>
    </label>

	<ul class="top-menu__list">
		<li onclick="location.href=./dashboard_parent_kids.php/';">
			<a href="/gaintimeoff/parent/dashboard"><?=$lg_kids?></a>
      	</li>
        <li onclick="location.href=\'add_kid.php\';">
        	<a href="/gaintimeoff/parent/adding-kid"><?=$lg_add_kid?></a>
    	</li>
        <li onclick="location.href=\'dashboard_parent_kids.php\';">
        	<a href="/gaintimeoff/parent/dashboard"><?=$lg_kids?></a>
    	</li>
        <li onclick="location.href=\'dashboard_parent_kids.php\';">
        	<a href="/gaintimeoff/parent/dashboard"><?=$lg_kids?></a>
    	</li>
    </ul>

    <div class="top-menu__block">
        <div class="block-content">
            <div class="block-content__text"><?=$helloParent?></div>
            <div class="block-content__link"><a href="/gaintimeoff/parent/logout"><?=$lg_logout?></a></div>
        </div>
    </div>
</div>