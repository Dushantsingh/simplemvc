<?php

/* 
@author Dushant Singh <maildushantsingh@gmail.com>.
@link https://github.com/Dushantsingh/simplemvc
 */
require ('framework/lib/httpRequest.php');
class mvc{
    
    
    public $_controllerName;
    public $_actionName;
    public static $instance;
    protected $_urlFragment = array();
    protected $_config;
    
    
    public function __construct($config = NULL){
        $this->_config = $config;
        $this->_request = new httpRequest();
        self::$instance = $this;
    }
    
    public function run(){

        /*SetUpRoutes*/
        self::urlHandler($this->_request->_requestUri);
        
        /*Find Controller*/
        self::setController();
        
        /*Find Action*/
        self::setAction();
        
        try {
             $this->runControllerAction();
        } catch (Exception $e) {
            
             echo $e->getMessage();
             echo "\n";
             echo $e->getTraceAsString();
        }
        /*Find Files and run actions*/
       
    }

    public static function  app(){
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function setController(){
        (isset($this->_urlFragment) && !empty($this->_urlFragment))?$this->_controllerName = $this->_urlFragment[0]:$this->_controllerName = $this->_config['defaultController'];
    }
    
    public function setAction(){
        (isset($this->_urlFragment) && !empty($this->_urlFragment))?(isset($this->_urlFragment[1])?$this->_actionName = $this->_urlFragment[1]:$this->_actionName=$this->_config['defaultAction']):$this->_actionName = $this->_config['defaultAction'];
    }
    
    public function urlHandler($url){
        if(isset($url)){
           $url =  preg_replace('/\?.*/','',$url);
           $url = trim($url, '/');
           if(strlen($url)>0)$this->_urlFragment = explode('/',$url);
        }
    }
    
    public function runControllerAction(){
        /*require Controller file*/
        $controllerFile = $this->_controllerName.'Controller.php';
        
        if(file_exists('app/controllers/'.$controllerFile)){
            require_once('app/controllers/'.$controllerFile);
        }else{
            throw  new Exception($this->_controllerName."Controller.php file does not exits");
        }
        
        $controllerclass = $this->_controllerName.'Controller';
        $this->controller = new $controllerclass();
        
        if(method_exists($this->controller,$this->_actionName)){
        $this->controller->{$this->_actionName}();
        }else{
            throw new Exception($this->_controllerName."Controller Does not have a ".$this->_actionName." method");
        }
    }
    
}

