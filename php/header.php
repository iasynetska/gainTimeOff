<?php echo

'<header class="header">
    <nav class="top-nav">
        <div class="container-fluid">
            <div class="row">
                <div class="col top-nav__logo">
                    <a href="welcome.php">GainTimeOff</a>
                </div>
                <div class="col">
                    <ul class="top-nav__lang d-flex justify-content-end">
                        <li>
                            <a class="link-english" href='.$_SERVER["SCRIPT_NAME"].'?lang=en>'.$lang["en"].'</a>
                        </li>
                        <li>
                            <div class="slash">|</div>
                        </li>
                        <li>
                            <a class="link-polish" href='.$_SERVER["SCRIPT_NAME"].'?lang=pl>'.$lang["pl"].'</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>';