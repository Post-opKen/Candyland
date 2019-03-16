<?php
/*
 * Amanda Williams
 * March 25, 2019
 * this class creates a profile object
 */

class Profile
{
    //fields
    private $_userId;
    private $_username;
    private $_boards;

    //construcor
    function __construct($userId)
    {
        $result = getUser($userId);

        $this->_userId=$userId;
        $this->_username = $result['username'];
        $this->_boards = explode(", ", $result['saved']);
    }

    function boardsToString()
    {
        implode(", ",$this->_boards);
    }

    function getUserBoards()
    {
        return getBoards($this->_boards);
    }
}