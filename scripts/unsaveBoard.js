/*
* Ean Daus
* 3/20/19
* unsaveBoard.js
* Event handlers for users unsaving boards
*/

//removes the board to the user's saved boards
$('.unsaveRecipe').on('click', function (){
    //passes the recipe's id via post to unsaveBoard.php
    $(this).load('model/unsaveBoard.php', {recipeId: $(this).attr('data-recipe-id')});
    $(this).parent().remove();
});

$('.unsaveArticle').on('click', function (){
    //passes the article's id via post to unsaveBoard.php
    $(this).load('model/unsaveBoard.php', {articleId: $(this).attr('data-article-id')});
    $(this).parent().remove();
});