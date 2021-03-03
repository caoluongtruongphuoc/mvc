<?php

require('../vendor/autoload.php');

define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

//require(ROOT . 'Config/core.php');
use App\Config\Core;
//require(ROOT . 'router.php');
use App\Router;
//require(ROOT . 'request.php');
use App\Request;
//require(ROOT . 'dispatcher.php');
use App\Dispatcher;

$dispatch = new Dispatcher();
$dispatch->dispatch();

?>