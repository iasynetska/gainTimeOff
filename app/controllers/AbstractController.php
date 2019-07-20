<?php
namespace controllers;
use core\Request;
use core\LangManager;

abstract class AbstractController
{
    protected $request;
    protected $langManager;
    
    public function __construct(Request $request, LangManager $langManager)
    {
        $this->request = $request;
        $this->langManager = $langManager;
    }
    
    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include $template;
        
        return ob_get_clean();
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
    
    protected function buildErrorMessage(array $errors)
    {
        $errorMessage = '';
        
        foreach($errors as $error)
        {
            $errorMessage .= $this->build(
                (dirname(__DIR__, 1)). '/views/errorMessage.html.php',
                [
                    'errorMessage' => $this->langManager->getLangParams()[$error]
                ]
                );
        }
        return $errorMessage;
    }
    
    abstract public function render();
}