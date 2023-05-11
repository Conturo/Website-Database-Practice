<?php
session_start();

$host = "localhost";
$port = "5432";
$user = "student";
$password = "CompSci364";
$db = "student";

$connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

$connection = pg_connect($connectionString);



pg_prepare($connection, "checkRecipe", "SELECT * FROM Recipes NATURAL JOIN Users WHERE recipe_name = $1 AND username = $2");
$result = pg_execute($connection, "checkRecipe", array($_POST["recipeName"], $_POST["author"]));


if (pg_num_rows($result) == 1) {

    $recipeId = pg_fetch_result($result, 0, 0);
    
    pg_prepare($connection, "removeRecipe", "DELETE FROM Recipes WHERE recipe_id = $1");

    $result = pg_execute($connection, "removeRecipe", array($recipeId));

    $location = $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/remRecipe.php");

} else {
    $_SESSION["error_message"] = "Failed to Remove Recipe";
    $location = $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/remRecipe.php");
}



pg_close($connection);

?>