Ean Daus and Amanda Williams
3/20/19
README.txt
Descriptions of how we fulfilled each project requirement.

1. Separates all database/business logic using the MVC pattern.
    Our site abides by the structure we have been using all quarter, with views in a views folder,
    all database code in the model folder etc.

2. Routes all URLs and leverages a templating language using the Fat-Free framework.
    index.php contains all of our routes. Every page displays using template.html, with an html
    include to add the content specific to each page. This allows us to reduce redundant code by
    using the same structure, nav and footer for every page.

3. Has a clearly defined database layer using PDO and prepared statements.
    Our database code is mostly contained withing model/db-functions.php. We use PDO prepared
    statements for all of our queries.

4. Data can be viewed, added, updated, and deleted.
    Data can be added by creating a new article or recipe in the /create route, or by creating a new user account.
    Data can be viewed in the following routes(found in index.php), where we display articles and recipes from the
    database:
    /, /articles, /recipes, /profile, and our parameterized route for board display(index.php line 288).
    Data can be updated by saving boards to the user
    Data can be deleted by removing saved boards from the user.

5. Has a history of commits from both team members to a Git repository.
    At the time of writing this document, we have over 90 commits, with a roughly equal number between us.

6. Uses OOP, and defines multiple classes, including at least one inheritance relationship.
    Our site has 4 classes(found in the classes directory), Board, Article and Recipe(both children of Board), and Profile.
    Article and Recipe are used to create and display articles and recipes for the site. Board is not used on its own, but
    only as the parent of Article and Recipe. Profile is used primarily to keep track of the currently logged in user.

7. Contains full Docblocks for all PHP files.
    All of our php files include full docblocks, as per PEAR standards.

8. Has full validation on the client side through JavaScript and server side through PHP.
    Data from the /create route is validated before being submitted. Data from /login and /signup are validated and
    checked against the database.

9. Incorporates jQuery and Ajax.
    Jquery and Ajax are used to check the availability of a username before an account is created(/signup route),
    as well as for adding and removing boards from a user's saved boards. We also use Jquery/Ajax for dynamically
    adding and removing input fields from the recipe form in the /create route. All javascript files can be found
    in the scripts directory.

BONUS:  Utilizes an API (Note:  If you do use an API, be sure to talk about it in your presentation.)
    Although I am unsure if this counts as utilizing an API, we did use an external library to help detect whether
    the client is a mobile device or not. The library itself can be found at classes/mobile-detect.php, and the code
    we wrote using it is in index.php, starting at line 30.

