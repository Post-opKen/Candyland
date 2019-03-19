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

#*******************************************************************************
//require autoload
require_once 'vendor/autoload.php';
$detect = new Mobile_Detect;

session_start();
require_once 'model/db-functions.php';
$dbh = connect();

#*******************************************************************************
//create an instance of the base class
$f3 = Base::instance();

//fat free error reporting
$f3->set('DEBUG', 3);

#*******************************************************************************
//DETECT DEVICE FOR MOBILE STYLES
global $detect;
if ($detect->isMobile() == 1) {
    //load the mobile styles
    $f3->set('mobileStyles', true);

} else {
    $f3->set('mobileStyles', false);
}

#*******************************************************************************
#-------------------------------------------------------------------------------
//Route to default route
$f3->route('GET|POST /', function ($f3) {
    //set title and content
    $f3->set('title', 'Scoop');
    $f3->set('contentPath', 'views/home.html');

    $f3->set('allBoards', getAllBoards());

    $template = new Template;
    echo $template->render('views/template.html');
});
//Route to home
$f3->route('GET|POST /home', function ($f3) {
    $f3->reroute('/');
});

#-------------------------------------------------------------------------------
//Route to article creation page
$f3->route('GET|POST /create', function ($f3) {
    //check if user is logged in
    if (!isset($_SESSION['user'])) {
        //Redirect
        $f3->reroute('/login');
    }

    //set page title
    $f3->set('title', 'Create');

    //set path for page content
    $f3->set('contentPath', 'views/create.html');
    
    //Article form Validation
    if (isset($_POST['articleBtn'])) {
        //Ensure fields not blank
        $isValid = true;
        if ($_POST['articleTitle'] == '') {
            $isValid = false;
            $f3->set('articleTitleError', 'Your article must have a title!');
        }
        if ($_POST['body'] == '') {
            $isValid = false;
            $f3->set('bodyError', 'Your article must have a body!');
        }
        if ($isValid) {
            //add article to DB
            addArticle($_POST['articleTitle'], $_SESSION['user']->getUserId(), $_POST['body'], $_POST['articleImg']);

            //clear POST data
            $_POST = array();

            //set success message
            $f3->set('createSuccess', 'Article created!');
        }
    }

    //Recipe form Validation
    if (isset($_POST['recipeBtn'])) {
        //Ensure fields not blank
        $isValid = true;
        if ($_POST['recipeTitle'] == '') {
            $isValid = false;
            $f3->set('recipeTitleError', 'Your recipe must have a title!');
        }
        if (isset($_POST['instructions'])) {
            //loop through array, only keeping nonempty indices
            $validInstructions = array();
            foreach ($_POST['instructions'] as $instruction)
            {
                if($instruction != '')
                {
                    //save only valid instructions
                    array_push($validInstructions, $instruction);
                }
            }
            //if the user gave at least one valid instruction
            if(!empty($validInstructions))
            {
                $_POST['instructions'] = $validInstructions;
            }else{
                $isValid = false;
                $f3->set('instructionError', 'Your recipe must have at least one instruction!');
            }
        }
        if (isset($_POST['ingredients'])) {//loop through array, only keeping nonempty indices
            $validIngredients = array();
            foreach ($_POST['ingredients'] as $ingredient)
            {
                if($ingredient != '')
                {
                    //save only valid instructions
                    array_push($validIngredients, $ingredient);
                }
            }
            //if the user gave at least one valid instruction
            if(!empty($validInstructions))
            {
                $_POST['ingredients'] = $validIngredients;
            }else{
                $isValid = false;
                $f3->set('ingredientError', 'Your recipe must have at least one ingredient!');
            }
        }
        if ($isValid) {
            //add article to DB
            addRecipe($_POST['recipeTitle'], $_SESSION['user']->getUserId(), $_POST['ingredients'], $_POST['instructions'], $_POST['recipeImg']);

            //clear POST data
            $_POST = array();

            //set success message
            $f3->set('createSuccess', 'Recipe created!');
        }
    }
    $template = new Template;
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
//Route to article display page
$f3->route('GET /article', function ($f3) {
    //set title and content
    $f3->set('title', $_SESSION['article']->getTitle());
    $f3->set('contentPath', 'views/articles.html');

    $template = new Template;
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
//Route to sign up page
$f3->route('GET|POST /signup', function ($f3) {
    //set title and content
    $f3->set('title', 'Sign Up');
    $f3->set('contentPath', 'views/signUp.html');

    //check if form has been submitted
    if (isset($_POST['name']) OR isset($_POST['pass'])) {
        require 'model/validation_functions.php';

        //validate form
        if (validateUsername($_POST['name']) AND validatePassword($_POST['pass'])) {
            //submit to db
            addUser($_POST['name'], $_POST['pass']);
            $f3->reroute('/login');
        }
    }
    $template = new Template;
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
//Route to login
$f3->route('GET|POST /login', function ($f3) {
    //set title and content
    $f3->set('title', 'Log in');
    $f3->set('contentPath', 'views/signIn.html');

    //check if form has been submitted
    if ($_POST['user'] != '' OR $_POST['pword'] != '') {
        //attempt to login
        $result = loginUser($_POST['user'], $_POST['pword']);

        //query DB for login credentials
        if ($result == false) {
            //failed to log in
            //set failure message
            $f3->set('loginError', 'Username or Password incorrect');
        } else {
            //create a profile object with the user's data
            $user = new Profile($result['user_id'], $result['username'], $result['saved']);

            //save user to session
            $_SESSION['user'] = $user;

            //reroute to home
            $f3->reroute('/');
        }
    }
    $template = new Template;
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
//Route to profile.html
$f3->route('GET|POST /profile', function ($f3) {
    //set title and content
    $f3->set('title', 'Profile');
    $f3->set('contentPath', 'views/profile.html');

    //Redirect
    if (!isset($_SESSION['user'])) {
        //User is not logged in
        $f3->reroute('/login');
    }

    //Set f3 vars for user info
    $f3->set('userId', $_SESSION['user']->getUserId());
    $f3->set('username', $_SESSION['user']->getUsername());
    $f3->set('boards', $_SESSION['user']->getBoards());
    $f3->set('boardStrings', $_SESSION['user']->getBoardStrings());


    $template = new Template();
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
//Route to articles.html
$f3->route('GET|POST /articles', function ($f3) {
    //set title and content
    $f3->set('title', "All Articles");
    $f3->set('contentPath', 'views/articles.html');

    $template = new Template();
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
//Route to recipes.html
$f3->route('GET|POST /recipes', function ($f3) {
    //set title and content
    $f3->set('title', "All Recipes");
    $f3->set('contentPath', 'views/recipes.html');

    $template = new Template();
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
//Route to board.html
$f3->route('GET|POST /board/@boardId', function ($f3, $params) {
    //set title and content
    $f3->set('title', 'Board Display');
    $f3->set('contentPath', 'views/board.html');

    //get board object
    $f3->set('board', getBoard($params['boardId']));

    $template = new Template();
    echo $template->render('views/template.html');
});

#-------------------------------------------------------------------------------
#*******************************************************************************
//run fat free
$f3->run();