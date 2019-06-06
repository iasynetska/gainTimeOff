<?php
namespace controllers;
use core\Request;
use core\LangManager;

class Controller
{
    protected $request;
    protected $title;
    protected $bodyId;
    protected $content;
    protected $langManager;
    protected $dynamicJS = '';
    
    public function __construct(Request $request, LangManager $langManager)
    {
        $this->request = $request;
        $this->title = '';
        $this->content = '';
        $this->langManager = $langManager;
    }
    
    protected function redirect($uri)
    {
        header(sprintf('Location: %s', $uri));
        exit();
    }
    
    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include $template;
        
        return ob_get_clean();
    }
    
    private function buildHeader()
    {
        return $this->build(
            (dirname(__DIR__, 1)). '/views/header.html.php',
            [
                'langActive' => $this->langManager->getSelectedLang(),
                'lg_en' => $this->langManager->getLangParams()['lg_en'],
                'lg_pl' => $this->langManager->getLangParams()['lg_pl']
            ]
        );
    }
    
    private function buildFooter()
    {
        return $this->build((dirname(__DIR__, 1)). '/views/footer.html.php');
    }
    
    protected function buildErrorMessage(array $errors)
    {
        $errorMessage = '';
        
        foreach($errors as $error)
        {
            $a = $this->langManager->getLangParams($error);
            $errorMessage .= $this->build(
                (dirname(__DIR__, 1)). '/views/errorMessage.html.php',
                [
                    'errorMessage' => $this->langManager->getLangParams()[$error]
                ]
            );
        }
        return $errorMessage;
    }
    
    public function render()
    {
        echo $this->build(
            (dirname(__DIR__, 1)). '/views/main.html.php',
            [
                'title' => $this->title,
                'bodyId' => $this->bodyId,
                'header' => $this->buildHeader(),
                'content' => $this->content,
                'footer' => $this->buildFooter(),
                'dynamicJS' => $this->dynamicJS
            ]
            );
    }
    
    protected function checkRequestMethod(String $method)
    {
        $methodCorrect = false;
        switch($method)
        {
            case $this->request::METHOD_POST:
                $methodCorrect = $this->request->isPost();
                break;
            case $this->request::METHOD_GET:
                $methodCorrect = $this->request->isGet();
                break;
        }
        if(!$methodCorrect)
        {
            http_response_code(400);
            echo sprintf("Request type - %s isn't support for uri: %s", $method, $this->request->getServerParam('REQUEST_URI'));
            exit();
        }
    }
}