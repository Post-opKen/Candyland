<?php
/*
 * Amanda Williams
 * March 25, 2019
 * this class creates a profile object
 */

require_once ('model/db-functions.php');
connect();

class Profile
{
    //fields
    private $_userId;
    private $_username;
    private $_boards;

    //construcor
    function __construct($userId)
    {
        //test array
        $boards = 'A3, A4, R3, R4';//array('A3', 'A4', 'R3', 'R4');

        $this->_userId=$userId;
        $this->_username = 'awilliams';//$result['username'];
        $this->_boards = explode(", ", $boards);//$result['saved']
    }

    //getters
    function getUserId()
    {
        return $this->_userId;
    }
    function getUsername()
    {
        return $this->_username;
    }
    function getBoards()
    {
        return $this->_boards;
    }

    //methods
    function boardsToString()
    {
        implode(", ",$this->_boards);
    }

    function getUserBoards()
    {
        return getBoards($this->_boards);
    }
}