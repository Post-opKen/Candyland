<?php

//try/catch for db require
try{
    if($_SERVER['USER'] == 'edausgre')
    {
        require("/home/edausgre/config.php");
    }else if($_SERVER['USER'] == 'awilliam')
    {
        require("/home/awilliam/config.php");
    }
}catch (Exception $e)
{
    echo $e->getMessage();
}

function connect()
{
    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME,
            DB_PASSWORD);
        //echo "Connected to database!!!";
        return $dbh;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}

//returns true if the name has been taken, false otherwise
function nameTaken($username)
{
    global $dbh;

    //1. define the query
    $sql = "SELECT * FROM candyland_users WHERE username = :username";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //bind params
    $statement->bindParam(':username', $username, PDO::PARAM_STR);

    //4. execute the statement
    $statement->execute();

    //5. return the result
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result!=null;
}

function addUser($name, $pass)
{
    global $dbh;

    //1. define the query
    $sql = "INSERT INTO candyland_users(username, password)
            VALUES (:username, :password)";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //3. bind parameters
    $statement->bindParam(':username', $name, PDO::PARAM_STR);
    $statement->bindParam(':password', password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);

    //4. execute the statement
    $success = $statement->execute();

    //5. return the result
    return $success;
}