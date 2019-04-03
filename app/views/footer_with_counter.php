<?php 

use models\CustomerNumberServices;

echo
'<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-3 col-md-2">
                <div class="footer-counter">
                    <p>'.$lang["visitors"].': '.$count.'</p>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <div class="footer-customers">
                    <p>'.$lang["customers"].': '.CustomerNumberServices::getNumberOfRegisteredUsers().'</p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-8">
                <div class="footer-copy">
                    <p class="footer-copy__text">&copy;2018 Viktoriia Iasynetska</p>
                </div>
            </div>
        </div>
    </div>
</footer>';