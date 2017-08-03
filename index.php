<?php 
error_reporting(E_ALL);
/*Require main file*/
require('framework/mvc.php');

/*Require configuration file*/
$config = require('app/config/config.php');
$mvc = new mvc($config);
$mvc->run();
?>