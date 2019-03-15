<?php
/*
 * Amanda Williams
 * March 25, 2019
 * this class creates a profile object
 */

class Profile
{
    //fields
    private $_username;
    private $_boards;

    //construcor
    function __construct($userId)
    {
        /*
        $sql = "SELECT * FROM candyland_users WHERE user_id=$userId";
        $statement=$dbh->prepare($sql);
        */

        $result = getUser($userId);

        $this->_username = $result['username'];
        $this->_boards = explode(", ", $result['saved']);
    }

    function boardsToString()
    {
        implode(", ",$this->_boards);
    }
}