<?php
/*
 * Ean Daus and Amanda Williams
 * 3/10/2019
 * board.php
 * Class that represents a board with a file path and title.
 */

/**
 * Class Board
 * A class that represents a board with a file path and a title.
 * @author Ean Daus
 * @version 1.0
 */
class Board
{
    /*
    private $_path;
    private $_title;
    */

    //Amanda's suggested fields
    private $_title;
    private $_author;
    private $_image_path;

    /**
     * Creates a new Board with a file path and a title.
     * @param $_path String The path from index to the board's location.
     * @param $_title String The title of the board.
     */
    /*
    public function __construct($_path, $_title)
    {
        $this->_path = $_path;
        $this->_title = $_title;
    }
    */
    //Amanda's suggested constructor
    public function __construct($title, $author, $imagePath)
    {
        $this->_title = $title;
        $this->_author= $author;
        $this->_image_path=$imagePath;
    }

    /**
     * @return String The file path of the Board.
     */
    /*
    public function getPath()
    {
        return $this->_path;
    }
    */

    /**
     * @return String The title of the Board.
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return string The author of the article.
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * @return string The path from index to the article's image.
     */
    public function getImagePath()
    {
        return $this->_image_path;
    }

    /**
     * @return String A string representation of the Board.
     */
    public function __toString()
    {
        return $this->_title . ': ';
    }
}