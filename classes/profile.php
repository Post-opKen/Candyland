<?php
/*
 * Amanda Williams
 * March 25, 2019
 * this class creates a profile object
 */

require_once('model/db-functions.php');

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