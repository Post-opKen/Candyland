<?php

require("/home/edausgre/config.php");

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
    $sql = "SELECT * FROM candyland_user WHERE username = :username";

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