<?php echo

'<header class="header">
    <nav class="top-nav">
        <div class="container-fluid">
            <div class="row">
                <div class="col top-nav_logo">
                    <a href="welcome.php">GainTimeOff</a>
                </div>
                <div class="col">
                    <ul class="top-nav_lang justify-content-end">
                        <li>
                            <a class="nav-link english" href='.$_SERVER["SCRIPT_NAME"].'?lang=en>'.$lang["en"].'</a>
                        </li>
                        <li>
                            <div class="nav-slash">|</div>
                        </li>
                        <li>
                            <a class="nav-link polish" href='.$_SERVER["SCRIPT_NAME"].'?lang=pl>'.$lang["pl"].'</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>';