<?php
/**
 * Ean Daus
 * 3/20/2019
 * unsaveBoard.php
 * Removes a board from the user's saved boards
 */
////php error reporting
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once 'db-functions.php';
require_once '../classes/profile.php';
session_start();

//connect to db
$dbh = connect();

//check if saving recipe or article
if (isset($_POST['recipeId'])) {
    //save the recipe
    unsaveRecipe($_SESSION['user']->getUserId(), $_SESSION['user']->boardsToString(), $_POST['recipeId']);
    $_SESSION['user']->removeBoard('R'.$_POST['recipeId']);
} elseif (isset($_POST['articleId'])) {
    //save the article
    unsaveArticle($_SESSION['user']->getUserId(), $_SESSION['user']->boardsToString(), $_POST['articleId']);
    $_SESSION['user']->removeBoard('A'.$_POST['articleId']);
}
