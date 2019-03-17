<?php

//try/catch for db require
try {
    if ($_SERVER['USER'] == 'edausgre') {
        require("/home/edausgre/config.php");
    } else if ($_SERVER['USER'] == 'awilliam') {
        require("/home/awilliam/config.php");
    }
} catch (Exception $e) {
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

    return $result != null;
}

//adds a new user to the database
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
    $statement->bindParam(':password', password_hash($pass, PASSWORD_BCRYPT), PDO::PARAM_STR);

    //4. execute the statement
    $success = $statement->execute();

    //5. return the result
    return $success;
}

function loginUser($user, $pass)
{
    global $dbh;

    //1. define the query
    $sql = "SELECT * FROM candyland_users WHERE username = :username";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //bind params
    $statement->bindParam(':username', $user, PDO::PARAM_STR);

    //4. execute the statement
    $statement->execute();

    //5. return the result
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    //6. return
    if ($result != false AND password_verify($pass, $result['password'])) {
        return $result;
    } else {
        return false;
    }
}

//gets a users data by user id
function getUser($userId)
{
    global $dbh;

    //create sql statement
    $sql = "SELECT * FROM candyland_users WHERE user_id=$userId";

    //prepare the statement
    $statement = $dbh->prepare($sql);

    //Execute statement
    $statement->execute();
    $result = $statement->fetchAll();
    //print_r($result);
    return $result;
}

function getBoards($boardIds)
{
    global $dbh;
    $outBoards = array();

    foreach ($boardIds as $boardId) {
        $id = substr($boardId, 1);
        echo "<p>" . substr($boardId, 0, 1) . "</p>";
        echo "<p>" . $id . "</p>";

        //set sql
        if (substr($boardId, 0, 1) == "A") {
            $sql = "SELECT * FROM candyland_articles
                WHERE article_id = $id";
            //echo "<p>Article</p>";
        } else if (substr($boardId, 0, 1) == "R") {
            $sql = "SELECT * FROM candyland_recipes
                WHERE recipe_id = $id";
            //echo "<p>this is a Recipe</p>";
        } else {
            echo "<p>INVALID BOARD TYPE</p>";
            return;
        }

        //echo $sql;
        //echo "sam";
        //print_r($dbh->prepare($sql));
        //echo"sam";

        //prepare statement
        $statement = $dbh->prepare($sql);
        //echo "pearl2";

        //execute statement
        $statement->execute();
        //echo "pearl3";

        //save results
        $results = $statement->fetchAll();

        //echo "pearl4";
        //print_r($results);

        //create object
        if (substr($boardId, 0) == "A") {
            $output = new Article();
        } else if (substr($boardId, 0) == "R") {
            $output = new Recipe();
        } else {
            echo "STILL INVALID ID";
            return;
        }

        //add to output array
        $outBoards += $output;
        print_r($output);
    }
    return $outBoards;
}

//print_r(getUser(1));

//print_r(getBoards(array('A3','A4','R3','R4')));