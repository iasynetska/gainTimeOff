<?php echo

'<div class="dashboard-menu d-flex flex-row justify-content-between align-items-center">
    <input id="dashboard-menu__toggle" type="checkbox" />
    <label class="dashboard-menu__wrap-button" for="dashboard-menu__toggle">
            <div class="dashboard-menu__button"></div>
    </label>

    <ul class="dashboard-menu__links">
      <li onclick="location.href=\'dashboard_parent_kids.php\';"><a href="dashboard_parent_kids.php">'.$lang['kids'].'</a></li>
      <li onclick="location.href=\'add_kid.php\';"><a href="add_kid.php">'.$lang['add_kid'].'</a></li>
      <li onclick="location.href=\'dashboard_parent_kids.php\';"><a href="dashboard_parent_kids.php">'.$lang['kids'].'</a></li>
      <li onclick="location.href=\'dashboard_parent_kids.php\';"><a href="dashboard_parent_kids.php">'.$lang['kids'].'</a></li>
    </ul>

    <div class="dashboard-menu__content">
        <div class="content__logout">
            <div class="logout-text">'.$lang['hello'].$parent->name.'</div>
            <div class="logout-link"><a href="./services/do_logout.php">'.$lang['logout'].'</a></div>
        </div>
    </div>
</div>';