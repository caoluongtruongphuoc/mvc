<?php

require('../vendor/autoload.php');

define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

use App\Config\Core;
use App\Router;
use App\Request;
use App\Dispatcher;

$dispatch = new Dispatcher();
$dispatch->dispatch();
