<?php
/**
 * Ean Daus
 * 3/13/2019
 * validateUsername.php
 * Checks the username in signUp.html against the DB
 */

require_once '../model/db-functions.php';

//connect to db
$dbh = connect();

//query db for username
if (nameTaken($_POST['username'])) {
    echo '<p class="text-danger">Username already taken.</p>';
} else {
    echo '<p class="text-success">Username available!</p>';
}