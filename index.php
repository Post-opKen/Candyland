<?php
/*
Ean Daus and Amanda Williams
3/10/19
index.php
Routing for Scoop
*/
//php error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require autoload
require_once 'vendor/autoload.php';
$detect = new Mobile_Detect;

session_start();

//create an instance of the base class
$f3 = Base::instance();

//fat free error reporting
$f3->set('DEBUG', 3);

//if website is loaded on a mobile device,
global $detect;
if ($detect->isMobile() == 1) {
    //load the mobile styles
    $f3->set('mobileStyles', true);
} else {
    $f3->set('mobileStyles', false);
}

//initialize DB connection
require 'model/db-functions.php';
$dbh = connect();

//define a default route
$f3->route('GET /', function ($f3) {
    //set page title
    $f3->set('title', 'Scoop');

    //set path for page content
    $f3->set('contentPath', 'views/home.html');

    $template = new Template;
    echo $template->render('views/template.html');
});

//Route for article creation page
$f3->route('GET /create', function ($f3) {
    //set page title
    $f3->set('title', 'Create');

    //set path for page content
    $f3->set('contentPath', 'views/create.html');

    //Has the form been submitted?
    if (isset($_GET['btn'])) {
        $article = new Article('views/article.html', $_GET['title'], $_GET['author'], $_GET['body'], $_GET['img']);
        $_SESSION['article'] = $article;
        $f3->reroute('/article');
    }

    $template = new Template;
    echo $template->render('views/template.html');
});

//Route for article display page
$f3->route('GET /article', function ($f3) {
    //set page title
    $f3->set('title', $_SESSION['article']->getTitle());

    //set path for page content
    $f3->set('contentPath', $_SESSION['article']->getPath());

    $template = new Template;
    echo $template->render('views/template.html');
});

//Route for sign up page
$f3->route('GET|POST /signup', function ($f3) {
    //set page title
    $f3->set('title', 'Sign Up');

    //set path for page content
    $f3->set('contentPath', 'views/signUp.html');

    //check if form has been submitted
    if(isset($_POST))
    {
        require 'model/validation_functions.php';

        //validate form
        if(validateUsername($_POST['name']) AND validatePassword($_POST['pass']))
        {
            //submit to db
            addUser($_POST['name'], $_POST['pass']);
            $f3->reroute('/login');
        }
    }

    $template = new Template;
    echo $template->render('views/template.html');
});

//Route for log in page
$f3->route('GET|POST /login', function ($f3) {
    //set page title
    $f3->set('title', 'Log in');

    //set path for page content
    $f3->set('contentPath', 'views/signIn.html');

    //check if form has been submitted
    if(isset($_POST))
    {
        require 'model/validation_functions.php';

        //query DB for login credentials
        if(false/*TODO The credentials are correct(use function in db-functions)*/)
        {
            //save userid to session

            //reroute to home
            $f3->reroute('/');
        }
    }

    $template = new Template;
    echo $template->render('views/template.html');
});

//run fat free
$f3->run();