<?php
/*
 * Amanda Williams
 * March 25, 2019
 * this class creates a profile object
 */

//try/catch for db-functions require
try {
    if ($_SERVER['USER'] == 'edausgre') {
        require_once('/home/edausgre/public_html/328/Candyland/model/db-functions.php');
    } else if ($_SERVER['USER'] == 'awilliam') {
        require_once('/home/awilliam/public_html/Candyland/model/db-functions.php');
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

$dbh = connect();

/**
 * Class Profile
 * A class that represents a profile with an id, username and list of saved boards.
 * @author Amanda Williams
 * @author Ean Daus
 * @version 1.0
 */
class Profile
{
    //fields
    private $_userId;
    private $_username;
    private $_boardStrings;
    private $_boards;

    //constructor

    /**
     * Creates a new Profile object.
     * @param $userId int The profile's id number.
     * @param $username string The profile's username.
     * @param $boards string The profile's saved boards, as a comma separated list.
     */
    function __construct($userId, $username, $boards)
    {
        $this->_userId = $userId;//$result['user_id'];
        $this->_username = $username;//$result['username'];
        $this->_boardStrings = explode(", ", $boards);//$result['saved']
        $this->_boards = getBoards($this->_boardStrings);
    }

    //getters

    /**
     * Gets the profile's id.
     * @return int The profile's id number.
     */
    function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Gets the profile's username.
     * @return string The profile's username.
     */
    function getUsername()
    {
        return $this->_username;
    }

    /**
     * Gets the profile's saved boards.
     * @return array The profile's array of saved board objects.
     */
    function getBoards()
    {
        return $this->_boards;
    }

    /**
     * Gets the profile's saved board strings.
     * @return array The profile's array of saved boards in strings.
     */
    function getBoardStrings()
    {
        return $this->_boardStrings;
    }

    /**
     * Saves an article to the user's saved boards.
     * @param $articleId int The id of the article to be saved
     */
    function addSavedArticle($articleId)
    {

        //if there are no saved boards
        if ($this->_boardStrings[0] == '') {

            //overwrite the empty element
            $this->_boardStrings[0] = "A$articleId";
        } else {

            //add the new id to the end of the array
            array_push($this->_boardStrings, "A$articleId");
        }
    }

    /**
     * Saves a recipe to the user's saved boards.
     * @param $recipeId int The id of the recipe to be saved
     */
    function addSavedRecipe($recipeId)
    {
        //if there are no saved boards
        if ($this->_boardStrings[0] == '') {

            //overwrite the empty element
            $this->_boardStrings[0] = "R$recipeId";
        } else {

            //add the new id to the end of the array
            array_push($this->_boardStrings, "R$recipeId");
        }
    }

    /**
     * Updates the boards field.
     */
    function updateBoards()
    {
        //update boards field
        $this->_boards = getBoards($this->_boardStrings);
    }

    /**
     * Removes a board from the arrays.
     * @param $boardId string The id of the board to be removed.
     */
    function removeBoard($boardId)
    {
        //remove board from array
        array_splice($this->_boardStrings, array_search($boardId, $this->_boardStrings), 1);

        //update boards field
        $this->updateBoards();
    }

    //other methods

    /**
     * Returns a string version of the profile's saved boards.
     * @return string The profile's array of saved boards as a comma separated string.
     */
    function boardsToString()
    {
        return implode(", ", $this->_boardStrings);
    }
}
