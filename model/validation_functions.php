<?php
/**
 * Ean Daus
 * 3/15/19
 * validation_functions.php
 * Validation functions
 */

require_once 'model/db-functions.php';
$dbh = connect();

/**
 * Validates the given username against the database.
 * @param $user string The name to be validated
 * @return bool True if username is available, false otherwise.
 */
function validateUsername($user)
{
    if(nameTaken($user))
    {
        //name not available(invalid)
        return false;
    }else{
        //name available
        return true;
    }
}

/**
 * Validates the given password.
 * @param $pass string The password to be validated.
 * @return bool True if password is valid, false otherwise.
 */
function validatePassword($pass)
{
    //check password via regex
    if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$/", $pass))
    {
        return true;
    }else{
        return false;
    }
}