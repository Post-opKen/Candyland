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
    return $result;
}

function getBoards($boardIds)
{
    global $dbh;
    $outBoards=array();

    foreach($boardIds as $board)
    {
        $id =substr($board,1);
        //set sql
        if(substr($board,0)=="A")
        {
            $sql = "SELECT * FROM candyland_articles
                WHERE article_id = $id";
        }
        else if(substr($board,0)=="R")
        {
            $sql = "SELECT * FROM candyland_recipes
                WHERE recipe_id = $id";
        }
        else
        {
            echo "INVALID BOARD TYPE";
            return;
        }

        //prepare statement
        $statement = $dbh->prepare($sql);

        //execute statement
        $statement->execute();

        //save results
        $results = $statement->fetchAll();

        //create object
        if(substr($board,0)=="A")
        {
            $output = new Article();
        }
        else if(substr($board,0)=="R")
        {
            $output = new Recipe();
        }
        else
        {
            echo "STILL INVALID ID";
            return;
        }

        //add to output array
        $outBoards+=$output;
    }
    return $outBoards;
}