<?php
namespace core;

class Request
{
    private $get;
    private $post;
    private $server;
    private $cookie;
    private $file;
    private $session;
    
    public function __construct($get, $post, $server, $cookie, $file, $session)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
        $this->cookie = $cookie;
        $this->file = $file;
        $this->session = $session;
    }
    
    public function getSessionParam($key)
    {
        return $this->getArr($this->session, $key);
    }
    
    public function addSessionParam($key, $param)
    {
        $this->session[$key] = $param;
    }
    
    private function getArr(array $arr, $key)
    {        
        if (isset($arr[$key])) 
        {
            return $arr[$key];
        }
        
        return NULL;
    }
}