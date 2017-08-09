<?php

/* 
@author Dushant Singh <maildushantsingh@gmail.com>.
@link https://github.com/Dushantsingh/simplemvc
 */
    
   class baseController{
	protected $_render;
       	public function __construct() {
       	}
	
	/*Render Function to capture file
	* Replace variables with data 
	* and return content */
	public function render($file_name,$data=array()){
		if($this->checkRenderFile($file_name)){
			return $this->_render;
		}
	}
        
        /*Check file in view folder and
	* return true and false*/
	public function checkRenderFile($file_name){
		return true;
	}
    } 
