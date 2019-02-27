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
$f3->route('GET /', function($f3){
    //set page title
    $f3->set('title', 'Scoop');

    //set path for page content
    $f3->set('contentPath', 'views/home.html');

    $template = new Template;
    echo $template->render('views/template.html');
});

//run fat free
$f3->run();