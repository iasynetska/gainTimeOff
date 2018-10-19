<?php echo

'<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-6">
                <div class="counter">
                    <p>'.$lang["visitors"].': '.$count.'</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-6">
                <div class="counter">
                    <p>'.$lang["customers"].': '.CustomerNumberServices::getNumberOfRegisteredUsers().'</p>
                </div>
            </div>
            <div class="col-md-8 col-sm-6 col-12">
                <div class="copy">
                    <p>&copy;2018 Viktoriia Iasynetska</p>
                </div>
            </div>
        </div>
    </div>
</footer>';