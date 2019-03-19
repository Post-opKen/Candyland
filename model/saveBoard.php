<?php
/**
 * Ean Daus
 * 3/19/2019
 * saveBoard.php
 * Saves a board to the user's saved boards
 */
//php error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../model/db-functions.php';

//connect to db
$dbh = connect();

//check if saving recipe or article
if (isset($_POST['recipeId'])) {
    //save the recipe
    saveRecipe($_SESSION['user']->getUserId(), $_SESSION['user']->boardsToString(), $_POST['recipeId']);
} elseif (isset($_POST['articleId'])) {
    //save the article
    saveArticle($_SESSION['user']->getUserId(), $_SESSION['user']->boardsToString(), $_POST['articleId']);
}
