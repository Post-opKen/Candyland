<?php
/*
 * Ean and Amanda
 * 3/20/19
 * db-functions.php
 * Methods for querying the database.
 */

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

/**
 * Makes a connection to the database.
 * @return null|PDO Returns a PDO object if connection was successful, null otherwise.
 */
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

/**
 * Queries the database for the given username, returning whether it is taken or not.
 * @param $username String The username to be tested against the database.
 * @return bool True if the username is already taken, false otherwise.
 */
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
/**
 * Adds a new user to the database with the given username and password.
 * @param $name string The username of the account.
 * @param $pass string The password of the account.
 * @return bool True if the account was added successfully, false otherwise.
 */
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

/**
 * Logs in the user with the given credentials.
 * @param $user string The username of the account to be logged in.
 * @param $pass string The password of the account to be logged in.
 * @return bool|mixed
 */
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
/**
 * Adds a new article to the database.
 * @param $title string The title of the article.
 * @param $author int The userId of the author of the article.
 * @param $text string The text of the article.
 * @param $image string The URL of the article's image.
 * @return bool True if the article was added successfully, false otherwise.
 */
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
/**
 * Adds a new recipe to the database.
 * @param $title string The title of the recipe.
 * @param $author int The userId of the author of the recipe.
 * @param $ingredients array An array of the recipe's ingredients.
 * @param $instructions array An array of the recipe's instructions.
 * @param $image string The URL of the recipe's image.
 * @return bool True if the recipe was added successfully, false otherwise.
 */
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

//returns an array of board objects
/**
 * Gets an array of board objects based on the board ids given.
 * @param $boardIds array An array of board ids.
 * @return array|bool Returns an array of board objects, or false if the operation failed.
 */
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
            return false;
        }

        //prepare statement
        $statement = $dbh->prepare($sql);

        //execute statement
        $statement->execute();

        //save results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        //create object
        if (substr($boardId, 0, 1) == "A") {
            $output = new Article(substr($boardId, 1), $results[0]['title'], $results[0]['author'], $results[0]['text'], $results[0]['image_path']);
        } else if (substr($boardId, 0, 1) == "R") {
            $output = new Recipe(substr($boardId, 1), $results[0]['title'], $results[0]['author'],
                explode("| ", $results[0]['ingredients']), explode("| ", $results[0]['instructions']),
                $results[0]['image_path']);
        } else {
            return false;
        }

        //add to output array
        $outBoards[sizeof($outBoards)] = $output;
    }
    return $outBoards;
}

/**
 * Gets all the boards stored in the database.
 * @return array An array of board objects.
 */
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
    foreach ($results as $article) {
        $articleObject = new Article($article['article_id'], $article['title'],
            $article['author'], $article['text'], $article['image_path']);
        $outputBoards[sizeof($outputBoards)] = $articleObject;
    }

    //get all recipes with sql
    $sql = "SELECT * FROM candyland_recipes";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    //loop and make recipe objects (add to output)
    foreach ($results as $recipe) {
        $recipeObject = new Recipe($recipe['recipe_id'], $recipe['title'],
            $recipe['author'], explode("| ", $recipe['ingredients']), explode("| ", $recipe['instructions']),
            $recipe['image_path']);
        $outputBoards[sizeof($outputBoards)] = $recipeObject;
    }

    //return result
    return $outputBoards;
}

//Save board
/**
 * Adds a new article to the user's list of saved articles.
 * @param $user_id int The id of the user.
 * @param $saved string A comma delimited string of the user's saved boards.
 * @param $articleId int The id of the article to be saved.
 * @return bool True if the operation was successful, false otherwise.
 */
function saveArticle($user_id, $saved, $articleId)
{
    global $dbh;

    //1. define the query
    $sql = "UPDATE candyland_users SET saved = :saved WHERE user_id = :user_id";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //append new article to saved boards
    $newSaved = $saved . ", A" . $articleId;

    //3. bind params
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $statement->bindParam(':saved', $newSaved, PDO::PARAM_STR);

    //4. execute the statement
    return $statement->execute();
}

/**
 * Adds a new recipe to the user's list of saved recipes.
 * @param $user_id int The id of the user.
 * @param $saved string A comma delimited string of the user's saved boards.
 * @param $recipeId int The id of the recipe to be saved.
 * @return bool True if the operation was successful, false otherwise.
 */
function saveRecipe($user_id, $saved, $recipeId)
{
    global $dbh;

    //1. define the query
    $sql = "UPDATE candyland_users SET saved = :saved WHERE user_id = :user_id";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //append new article to saved boards
    $saved = $saved . ", R" . $recipeId;

    //3. bind params
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $statement->bindParam(':saved', $saved, PDO::PARAM_STR);

    //4. execute the statement
    return $statement->execute();
}

//Save board
/**
 * Removes an article from the user's list of saved articles.
 * @param $user_id int The id of the user.
 * @param $saved string A comma delimited string of the user's saved boards.
 * @param $articleId int The id of the article to be removed.
 * @return bool True if the operation was successful, false otherwise.
 */
function unsaveArticle($user_id, $saved, $articleId)
{
    global $dbh;

    //1. define the query
    $sql = "UPDATE candyland_users SET saved = :saved WHERE user_id = :user_id";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //remove the article from the array
    $savedArray = explode(', ', $saved);
    $needle = array_search("A$articleId", $savedArray);
    array_splice($savedArray, $needle, 1);
    $newSaved = implode(', ', $savedArray);

    //3. bind params
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $statement->bindParam(':saved', $newSaved, PDO::PARAM_STR);

    //4. execute the statement
    return $statement->execute();
}

/**
 * Removes a recipe from the user's list of saved recipes.
 * @param $user_id int The id of the user.
 * @param $saved string A comma delimited string of the user's saved boards.
 * @param $recipeId int The id of the recipe to be removed.
 * @return bool True if the operation was successful, false otherwise.
 */
function unsaveRecipe($user_id, $saved, $recipeId)
{
    global $dbh;

    //1. define the query
    $sql = "UPDATE candyland_users SET saved = :saved WHERE user_id = :user_id";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //remove the article from the array
    $savedArray = explode(', ', $saved);
    $needle = array_search("R$recipeId", $savedArray);
    array_splice($savedArray, $needle, 1);
    $newSaved = implode(', ', $savedArray);

    //3. bind params
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $statement->bindParam(':saved', $newSaved, PDO::PARAM_STR);

    //4. execute the statement
    return $statement->execute();
}

/**
 * Retrieves a board with the given id from the database.
 * @param string $boardId The id of the board to be retrieved.
 * @return Article|bool|Recipe Returns an Article or Recipe object with the given id, or false if the operation failed.
 */
function getBoard($boardId)
{
    global $dbh;
    $id = substr($boardId, 1);
    //is board id for article or recipe?
    if (substr($boardId, 0, 1) == "A") {
        $sql = "SELECT * FROM candyland_articles WHERE article_id=$id";
    } elseif (substr($boardId, 0, 1) == "R") {
        $sql = "SELECT * FROM candyland_recipes WHERE recipe_id=$id";
    } else {
        //invalid board id
        return false;
    }
    //statement
    $statement = $dbh->prepare($sql);
    $statement->execute();

    //results
    $results = $statement->fetch(PDO::FETCH_ASSOC);

    //return board object
    if (substr($boardId, 0, 1) == "A") {
        return new Article($results['article_id'], $results['title'], $results['author'],
            $results['text'], $results['image_path']);
    } elseif (substr($boardId, 0, 1) == "R") {
        return new Recipe($results['recipe_id'], $results['title'], $results['author'],
            explode("| ", $results['ingredients']), explode("| ", $results['instructions']), $results['image_path']);
    } else {
        //still invalid, how did you get here?
        return false;
    }
}

/**
 * Returns an array of all articles in the database as Article objects.
 * @return array An array of Article objects.
 */
function getArticles()
{
    global $dbh;
    $output = array();

    $sql = "SELECT * FROM candyland_articles";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $article) {
        $output[sizeof($output)] = new Article($article['article_id'], $article['title'],
            $article['author'], $article['text'], $article['image_path']);
    }
    return $output;
}

/**
 * Returns an array of all recipes in the database as Recipe objects.
 * @return array An array of Recipe objects.
 */
function getRecipes()
{
    global $dbh;
    $output = array();

    $sql = "SELECT * FROM candyland_recipes";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $recipe) {
        $output[sizeof($output)] = new Recipe($recipe['recipe_id'], $recipe['title'],
            $recipe['author'], explode("| ", $recipe['ingredients']),
            explode("| ", $recipe['instructions']), $recipe['image_path']);
    }
    return $output;
}

//gets a users data by user id
/**
 * Retrives a Profile object for the user with the given id.
 * @param int $userId The id of the user to be retrieved.
 * @return Profile A Profile object containing the user's data.
 */
function getUser($userId)
{
    global $dbh;

    //create sql statement
    $sql = "SELECT * FROM candyland_users WHERE user_id=$userId";

    //prepare the statement
    $statement = $dbh->prepare($sql);

    //Execute statement
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $user = new Profile($result['user_id'], $result['username'], $result['saved']);

    return $user;
}