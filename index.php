<?php
/*
Ean Daus
DATE
index.php
DESCRIPTION
*/
//php error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require autoload
require_once 'vendor/autoload.php';

//create an instance of the base class
$f3 = Base::instance();

//fat free error reporting
$f3->set('DEBUG', 3);

//define a default route
$f3->route('GET /', function(){
    $view = new View;
    echo $view->render('views/home.html');
});

//run fat free
$f3->run();