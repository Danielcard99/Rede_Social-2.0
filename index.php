<?php

session_start();
require('vendor/autoload.php');
date_default_timezone_set('America/Bahia');

define('INCLUDE_PATH_STATIC', 'http://localhost/Rede_Social-2.0/Classes/Views/pages/');
define('INCLUDE_PATH', 'http://localhost/Rede_Social-2.0/');
$app = new Classes\Application();

$app->run();

