<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class mvc{
    
    public $controller;
    
    protected $_controllerName;
    protected $_actionName;
    protected $_urlFragment = array();
    protected $_config;
    
    
    public function __construct($config = NULL){
        $this->_config = $config;
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
        $pathInfo = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] :
	    (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
        $this->_urlFragment = !empty($pathInfo) ? array_filter(explode('/',$pathInfo)) : null;
    }
    
    public function setController(){
        isset($this->_urlFragment)?$this->_controllerName = $this->_urlFragment[1]:$this->_controllerName = $this->_config['defaultController'];
    }
    
    public function setAction(){
        isset($this->_urlFragment)?(isset($this->_urlFragment[2])?$this->_actionName = $this->_urlFragment[2]:$this->_actionName=$this->_config['defaultAction']):$this->_actionName = $this->_config['defaultAction'];
    }
    
    public function runControllerAction(){
        
        /*require Controller file*/
        $controllerFile = $this->_controllerName.'Controller.php';
        require_once('app/controllers/'.$controllerFile);
        
        $controllerclass = $this->_controllerName.'Controller';
        $this->controller = new $controllerclass();
        $this->controller->{$this->_actionName}();
    }
    
}

