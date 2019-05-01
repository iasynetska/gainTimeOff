<?php
namespace core;

class Request
{
    private $get;
    private $post;
    private $cookie;
    private $file;
    
    public function __construct($get, $post, $cookie, $file)
    {
        $this->get = $get;
        $this->post = $post;
        $this->cookie = $cookie;
        $this->file = $file;
    }
    
    public function getSessionParam($key)
    {
        return $this->getParam($_SESSION, $key);
    }
    
    public function addSessionParam($key, $param)
    {
        $_SESSION[$key] = $param;
    }
    
    public function getServerParam($key)
    {
        return $this->getParam($_SERVER, $key);
    }
    
    public function addServerParam($key, $param)
    {
        $_SERVER[$key] = $param;
    }
    
    public function getGetParam($key)
    {
        return $this->getParam($this->get, $key);
    }
    
    public function addGetParam($key, $param)
    {
        $this->get[$key] = $param;
    }
    
    public function getPostParam($key)
    {
        return $this->getParam($this->post, $key);
    }
    
    public function addPostParam($key, $param)
    {
        $this->post[$key] = $param;
    }
    
    public function getCookieParam($key)
    {
        return $this->getParam($this->cookie, $key);
    }
    
    public function addCookieParam($key, $param)
    {
        $this->cookie[$key] = $param;
    }
    
    public function getFileParam($key)
    {
        return $this->getParam($this->file, $key);
    }
    
    public function addFileParam($key, $param)
    {
        $this->file[$key] = $param;
    }
    
    private function getParam(array $arr, $key)
    {        
        if (isset($arr[$key])) 
        {
            return $arr[$key];
        }
        return NULL;
    }
}