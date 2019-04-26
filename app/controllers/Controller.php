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
    
    public function __construct(Request $request, LangManager $lang)
    {
        $this->request = $request;
        $this->title = '';
        $this->content = '';
        $this->langManager = $lang;
    }
    
    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include_once $template;
        
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
    
    public function render()
    {
        echo $this->build(
            (dirname(__DIR__, 1)). '/views/main.html.php',
            [
                'title' => $this->title,
                'bodyId' => $this->bodyId,
                'header' => $this->buildHeader(),
                'content' => $this->content,
                'footer' => $this->buildFooter()
            ]
            );
    }
}