<?php
/**
 * Created by PhpStorm.
 * User: Ean
 * Date: 3/10/2019
 * Time: 6:41 PM
 */

class Article extends Board
{
    private $_author;
    private $_body;
    private $_imgPath;

    /**
     * Article constructor.
     * @param $path
     * @param $title
     * @param $author
     * @param $body
     * @param $imgPath
     */
    public function __construct($path, $title, $author, $body, $imgPath = "DEFAULT")
    {
        parent::__construct($path, $title);
        $this->_author = $author;
        $this->_body = $body;
        $this->_imgPath = $imgPath;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * @return mixed
     */
    public function getImgPath()
    {
        return $this->_imgPath;
    }

    public function __toString()
    {
        return parent::__toString() . ", " . $this->_author . ", " . $this->_imgPath;
    }


}