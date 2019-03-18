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
    /*
    private $_author;
    private $_body;
    private $_imgPath;
    */
    //Amanda's suggested fields
    private $_text_content;

    /**
     * Creates a new Article object.
     * @param string $path The path from index to the article's location.
     * @param string $title The title of the article.
     * @param string $author The author of the article.
     * @param string $body The body of the article.
     * @param string $imgPath The path from index to the article's image.
     */
    /*
    public function __construct($path, $title, $author, $body, $imgPath = "DEFAULT")
    {
        parent::__construct($path, $title);
        $this->_author = $author;
        $this->_body = $body;
        $this->_imgPath = $imgPath;
    }
    */

    //Amanda's suggested constructor
    public function __construct($title, $author, $textContent, $imagePath = "DEFAULT")
    {
        parent::__construct($title, $author, $imagePath);
        $this->_text_content=$textContent;
    }

    /**
     * this function provides access to the articles content
     * @return mixed, the text content of the article.
     */
    public function getTextContent()
    {
        return $this->_text_content;
    }

    /**
     * @return string The author of the article.
     */
    /*
    public function getAuthor()
    {
        return $this->_author;
    }
    */

    /**
     * @return string The body of the article.
     */
    /*
    public function getBody()
    {
        return $this->_body;
    }
    */

    /**
     * @return string The path from index to the article's image.
     */
    /*
    public function getImgPath()
    {
        return $this->_imgPath;
    }
    */

    /**
     * @return string A string representation of the article.
     */
    /*
    public function __toString()
    {
        return parent::__toString() . ", " . $this->_author . ", " . $this->_imgPath;
    }
    */


}