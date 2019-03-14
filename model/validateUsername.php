<?php
/**
 * Ean Daus
 * 3/13/2019
 * validateUsername.php
 * Checks the username in signUp.html against the DB
 */
//php error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../model/db-functions.php';

//connect to db
$dbh = connect();

//query db for username
if (nameTaken($_POST['username'])) {
    echo '<p class="text-danger">Username already taken.</p>';
} else {
    echo '<p class="text-success">Username available!</p>';
}