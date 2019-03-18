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
class Recipe extends Board
{
    private $_ingredients = array();
    private $_instructions = array();


    /**
     * Creates a new Recipe object.
     * @param string $title The title of the recipe.
     * @param string $author The author of the recipe.
     * @param array $ingredients A list of the ingredients for the recipe.
     * @param array $instructions A list of the instructions for the recipe.
     * @param string $imgPath The path from index to the recipe's image.
     */
    public function __construct($title, $author, array $ingredients, array $instructions, $imgPath = "DEFAULT")
    {
        parent::__construct($title, $author, $imgPath);
        $this->_ingredients = $ingredients;
        $this->_instructions = $instructions;
    }

    /**
     * @return array The recipe's ingredient list.
     */
    public function getIngredients()
    {
        return $this->_ingredients;
    }

    /**
     * @return array The recipe's ingredient list.
     */
    public function getInstructions()
    {
        return $this->_instructions;
    }


    /**
     * @return string A string representation of the recipe.
     */
    public function __toString()
    {
        return parent::__toString();
    }


}