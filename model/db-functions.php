<?php
//php error reporting
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
//
//session_start();
//
//require ('../classes/board.php');
//require ('../classes/article.php');
//require ('../classes/recipe.php');

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

//adds a new article to the database
function addArticle($title, $author, $text, $image)
{
    global $dbh;

    //1. define the query
    $sql = "INSERT INTO candyland_articles(title, author, text, image_path)
	            VALUES (:title, :author, :text, :image)";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //3. bind parameters
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':author', $author, PDO::PARAM_STR);
    $statement->bindParam(':text', $text, PDO::PARAM_STR);
    $statement->bindParam(':image', $image, PDO::PARAM_STR);

    //4. execute the statement
    $success = $statement->execute();

    //5. return the result
    return $success;
}

//adds a new recipe to the database
function addRecipe($title, $author, $ingredients, $instructions, $image)
{
    global $dbh;

    //1. define the query
    $sql = "INSERT INTO candyland_recipes(title, author, ingredients, instructions, image_path)
	            VALUES (:title, :author, :ingredients, :instructions, :image)";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //3. bind parameters
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':author', $author, PDO::PARAM_STR);
    $statement->bindParam(':ingredients', implode('| ', $ingredients), PDO::PARAM_STR);
    $statement->bindParam(':instructions', implode('| ', $instructions), PDO::PARAM_STR);
    $statement->bindParam(':image', $image, PDO::PARAM_STR);

    //4. execute the statement
    $success = $statement->execute();

    //5. return the result
    return $success;
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

//returns an array of board objects
function getBoards($boardIds)
{
    global $dbh;

    $outBoards = array();

    foreach ($boardIds as $boardId) {
        $id = substr($boardId, 1);

        //set sql
        if (substr($boardId, 0, 1) == "A") {
            $sql = "SELECT * FROM candyland_articles
                WHERE article_id = $id";
        } else if (substr($boardId, 0, 1) == "R") {
            $sql = "SELECT * FROM candyland_recipes
                WHERE recipe_id = $id";
        } else {
            echo "<p>INVALID BOARD TYPE</p>";
            return;
        }

        //prepare statement
        $statement = $dbh->prepare($sql);

        //execute statement
        $statement->execute();

        //save results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        //create object
        if (substr($boardId, 0, 1) == "A") {
            $output = new Article(substr($boardId, 1), $results[0]['title'], $results[0]['author'], $results[0]['text'],
                $results[0]['image_path']);
        } else if (substr($boardId, 0, 1) == "R") {
            $output = new Recipe(substr($boardId, 1), $results[0]['title'], $results[0]['author'],
                explode("| ", $results[0]['ingredients']), explode("| ", $results[0]['instructions']),
                $results[0]['image_path']);
        } else {
            echo "STILL INVALID ID";
            return;
        }

        //add to output array
        $outBoards[sizeof($outBoards)] = $output;
    }
    return $outBoards;
}

function getAllBoards()
{
    global $dbh;

    //eventual output
    $outputBoards = array();

    //get all articles with sql
    $sql = "SELECT * FROM candyland_articles";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    //loop and make article objects (add to output)
    foreach ($results as $article)
    {
        $articleObject = new Article($article['article_id'], $article['title'],
            $article['author'], $article['text'], $article['image_path']);
        $outputBoards[sizeof($outputBoards)]=$articleObject;
    }

    //get all recipes with sql
    $sql = "SELECT * FROM candyland_recipes";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    //loop and make recipe objects (add to output)
    foreach ($results as $recipe)
    {
        $recipeObject = new Recipe($recipe['recipe_id'], $recipe['title'],
            $recipe['author'], explode("| ",$recipe['ingredients']), explode("| ",$recipe['instructions']),
            $recipe['image_path']);
        $outputBoards[sizeof($outputBoards)]=$recipeObject;
    }

    //return result
    return $outputBoards;
}

//$dbh=connect();
////test get all boards
//
//$_SESSION['allBoards']=getAllBoards();
//print_r($_SESSION['allBoards']);