<?php

/* 
@author Dushant Singh <maildushantsingh@gmail.com>.
@link https://github.com/Dushantsingh/simplemvc
 */

class httpRequest{
    
    public $_requestUri;
    public $_requestData = array();
    
    public function __construct(){
        self::processRequest();
        self::processRequestData();
        self::getRequestType();
    }
    
    public function processRequest(){
        
        if($this->_requestUri===null)
		{
			if(isset($_SERVER['HTTP_X_REWRITE_URL'])) // IIS
				$this->_requestUri=$_SERVER['HTTP_X_REWRITE_URL'];
			elseif(isset($_SERVER['REQUEST_URI']))
			{
				$this->_requestUri=$_SERVER['REQUEST_URI'];
				if(!empty($_SERVER['HTTP_HOST']))
				{
					if(strpos($this->_requestUri,$_SERVER['HTTP_HOST'])!==false)
						$this->_requestUri=preg_replace('/^\w+:\/\/[^\/]+/','',$this->_requestUri);
				}
				else
					$this->_requestUri=preg_replace('/^(http|https):\/\/[^\/]+/i','',$this->_requestUri);
			}
			elseif(isset($_SERVER['ORIG_PATH_INFO']))  // IIS 5.0 CGI
			{
				$this->_requestUri=$_SERVER['ORIG_PATH_INFO'];
				if(!empty($_SERVER['QUERY_STRING']))
					$this->_requestUri.='?'.$_SERVER['QUERY_STRING'];
			}
			else
				throw new Exception('Unable to process request');
		}
                
    }
    
    public function processRequestData(){
        
        if(isset($_GET) && count($_GET)>0)
            $this->_requestData = $_GET;
        elseif(isset($_POST) && count($_POST))
            $this->_requestData = $_POST;
    } 
    
    public function getRequestType(){
        return strtoupper(isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:'GET');
    }
}