/*
* Ean Daus
* 3/19/19
* saveBoard.js
* Event handlers for users saving boards
*/

//Saves the board to the user's saved boards
$('.saveRecipe').on('click', function (){
    //passes the recipe's id via post to saveBoard.php
    $(this).load('model/saveBoard.php', {recipeId: $(this).attr('data-recipe-id')});
    $(this).remove();
});

$('.saveArticle').on('click', function (){
    //passes the article's id via post to saveBoard.php
    $(this).load('model/saveBoard.php', {articleId: $(this).attr('data-article-id')});
    $(this).remove();
});