<?php
/*
 * Ean Daus and Amanda Williams
 * 3/10/2019
 * article.php
 * Class that represents an article.
 */

/**
 * Class Article
 * A class that represents an article with an author, body and optional image path.
 * @author Ean Daus
 * @version 1.0
 */
class Article extends Board
{
    private $_body;

    /**
     * Creates a new Article object.
     * @param string $title The title of the article.
     * @param string $body The body of the article.
     */
    public function __construct($boardId, $title, $author, $body, $imgPath = "DEFAULT")
    {
        parent::__construct($boardId, $title, $author, $imgPath);
        $this->_body = $body;
    }

    /**
     * @return string The body of the article.
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * @return string A string representation of the article.
     */
    public function __toString()
    {
        return parent::__toString();
    }




}