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
    private $_title;
    private $_author;
    private $_imgPath;
    private $_boardId;

    /**
     * Creates a new Board with a file path and a title.
     * @param int $boardId The id of the board.
     * @param string $title The title of the board.
     * @param string $author The author of the board.
     * @param string $imgPath The url of the board's image.
     */
    public function __construct($boardId, $title, $author, $imgPath = "DEFAULT")
    {
        $this->_boardId = $boardId;
        $this->_title = $title;
        $this->_author = $author;
        $this->_imgPath = $imgPath;
    }

    /**
     * @return String The id of the Board.
     */
    public function getBoardId()
    {
        return $this->_boardId;
    }


    /**
     * @return String The title of the Board.
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return string The author of the board.
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * @return string The path from index to the board's image.
     */
    public function getImgPath()
    {
        return $this->_imgPath;
    }

    /**
     * @return String A string representation of the Board.
     */
    public function __toString()
    {
        return $this->_title . " By " . $this->_author;
    }
}