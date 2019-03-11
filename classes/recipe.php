<?php
/*
 * Ean Daus and Amanda Williams
 * 3/10/2019
 * recipe.php
 * Class that represents a recipe.
 */

/**
 * Class Recipe
 * A class that represents a recipe with a list of ingredients and a time.
 * @author Ean Daus
 * @version 1.0
 */
class Recipe extends Article
{
    private $_ingredients = array();
    private $_time;

    /**
     * Creates a new Recipe object.
     * @param string $path The path from index to the recipe's location.
     * @param string $title The title of the recipe.
     * @param string $author The author of the recipe.
     * @param string $body The body of the recipe.
     * @param array $ingredients A list of the ingredients for the recipe.
     * @param integer $time The amount of time it takes to complete the recipe.
     * @param string $imgPath The path from index to the recipe's image.
     */
    public function __construct($path, $title, $author, $body, array $ingredients, $time, $imgPath = "DEFAULT")
    {
        parent::__construct($path, $title, $author, $body, $imgPath);
        $this->_ingredients = $ingredients;
        $this->_time = $time;
    }

    /**
     * @return array The recipe's ingredient list.
     */
    public function getIngredients()
    {
        return $this->_ingredients;
    }

    /**
     * @return integer The amount of time it takes to finish the recipe.
     */
    public function getTime()
    {
        return $this->_time;
    }

    /**
     * @return string A string representation of the recipe.
     */
    public function __toString()
    {
        return parent::__toString();
    }


}