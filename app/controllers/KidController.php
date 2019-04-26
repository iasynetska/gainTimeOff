<?php
namespace controllers;

class KidController extends Controller
{
    public function loginAction()
    {
        $this->title = 'Kid login';
        $this->bodyId = 'kidLogin';
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/kidLogin.html.php',
            [
                'lg_kid' => $this->langManager->getLangParams()['lg_kid'],
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_login_submit' => $this->langManager->getLangParams()['lg_login_submit']
            ]
            );
    }
}