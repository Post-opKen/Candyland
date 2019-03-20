<?php
/**
 * Ean Daus
 * 3/19/2019
 * saveBoard.php
 * Saves a board to the user's saved boards
 */

require_once 'db-functions.php';
require_once '../classes/profile.php';
session_start();

//connect to db
$dbh = connect();

//check if saving recipe or article
if (isset($_POST['recipeId'])) {
    //save the recipe
    saveRecipe($_SESSION['user']->getUserId(), $_SESSION['user']->boardsToString(), $_POST['recipeId']);
    $_SESSION['user']->addSavedRecipe($_POST['recipeId']);
} elseif (isset($_POST['articleId'])) {
    //save the article
    saveArticle($_SESSION['user']->getUserId(), $_SESSION['user']->boardsToString(), $_POST['articleId']);
    $_SESSION['user']->addSavedArticle($_POST['articleId']);
}
