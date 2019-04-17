<?php
namespace core;

class LangManager
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    private function getSelectedLang() 
    {
        $lang = filter_input(INPUT_GET, 'lang');
        
        if(($lang==='en' || $lang==='pl') && $this->request->getSessionParam('lang')!==$lang)
        {
            $this->request->addSessionParam('lang', $lang);
        }
        else if($this->request->getSessionParam('lang') === NULL)
        {
            $this->request->addSessionParam('lang', 'en');
        }
        return $this->request->getSessionParam('lang');
    }
    
    public function getLangParams()
    {
        $lang = $this->getSelectedLang();
        return include (dirname(__DIR__, 1)). '/languages/' . $lang . '.php';
    }
}