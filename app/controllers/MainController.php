<?php
namespace controllers;

class MainController extends FullHtmlController
{
    public function indexAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $this->title = 'GainTimeOff';
        $this->bodyId = 'welcome';
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/index.html.php', 
            [
                'lg_kid' => $this->langManager->getLangParams()['lg_kid'],
                'lg_parent' => $this->langManager->getLangParams()['lg_parent']
            ]
        );        
    }
}