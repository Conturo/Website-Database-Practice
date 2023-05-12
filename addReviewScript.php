<?php
session_start();

$host = "localhost";
$port = "5432";
$user = "student";
$password = "CompSci364";
$db = "student";

$connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

$connection = pg_connect($connectionString);

    #   get user ID
    pg_prepare($connection, "userIDGet", "SELECT * FROM Users WHERE username = $1");
    $result = pg_execute($connection, "userIDGet", array($_SESSION["username"]));
    $userId = (int) (pg_fetch_result($result, 0, 0));

    #   get recipe ID
    pg_prepare($connection, "recipeIDGet", "SELECT recipe_id FROM Recipes WHERE recipe_name = $1");
    $result = pg_execute($connection, "recipeIDGet", array($_POST["recipeName"]));
    $recipeId = pg_fetch_result($result, 0, 0);

    #   Rating
    pg_prepare($connection, "userRecipeRating", "INSERT INTO Users_Recipes_Ratings (user_id, recipe_id, rating) VALUES ($1, $2, $3)");
    $result = pg_execute($connection, "userRecipeRating", array($userId, $recipeId, (int)($_POST["rating"])));

    #   Review
    pg_prepare($connection, "userRecipeReview", "INSERT INTO Users_Recipes_Reviews (user_id, recipe_id, review_text) VALUES ($1, $2, $3)");
    $result = pg_execute($connection, "userRecipeReview", array($userId, $recipeId, $_POST["review"]));

    $location = $location = dirname($_SERVER["PHP_SELF"]);
    if($result == false){
        $_SESSION["message"] = "You have already left a review for this recipe!";
    }
    else{
        $_SESSION["message"] = "Review successfully added!";
    }
    header("Location: $location/addReview.php");

pg_close($connection);

?>