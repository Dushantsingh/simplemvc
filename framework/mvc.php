<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class mvc{
    
    public $controller;
    
    protected $_controllerNameName;
    protected $_actionName;
    protected $_routes = array();
    protected $_urlFragment = array();
    protected $_pathInfo;
    
    
    public function __construct(){
        $this->_controllerName = 'site';
        $this->_actionName = 'index';
    }
    
    public function run(){
        
        /*SetUpRoutes*/
        $this->urlFragments();
        
        /*Find Controller*/
        $this->setController();
        
        /*Find Action*/
        $this->setAction();
        
        /*Find Files and run actions*/
        $this->runControllerAction();
    }
    
    public function urlFragments(){
        $this->_pathInfo= !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] :
	    (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
        $this->_urlFragment = !empty($this->_pathInfo) ? array_filter(explode('/',$this->_pathInfo)) : null;
    }
    
    public function setController(){
        isset($this->_urlFragment)?$this->_controllerName = $this->_urlFragment[1]:$this->_controllerName = 'site';
    }
    
    public function setAction(){
        isset($this->_urlFragment)?(isset($this->_urlFragment[2])?$this->_actionName = $this->_urlFragment[2]:$this->_actionName='index'):$this->_controllerName = 'site';
    }
    
    public function runControllerAction(){
        
        /*require Controller file*/
        $controllerFile = $this->_controllerName.'controller.php';
        require_once('app/controllers/'.$controllerFile);
        
        $controllerclass = $this->_controllerName.'controller';
        $this->controller = new $controllerclass();
        $this->controller->{$this->_actionName}();
    }
    
}

