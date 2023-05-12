<?php
session_start();

$host = "localhost";
$port = "5432";
$user = "student";
$password = "CompSci364";
$db = "student";

$connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

$connection = pg_connect($connectionString);


pg_prepare($connection, "checkExistingRecipies", "SELECT * FROM Recipes ".
                                                  "WHERE recipe_name = $1");
pg_prepare($connection, "checkRceipeIDAvailable", "SELECT * FROM Users WHERE user_id = $1");

$rand_id = rand(1, 100000000);

$result = pg_execute($connection, "checkRecipeIDAvailable", $rand_id);

while (pg_num_rows($result) != 0) {
    $rand_id = rand(1, 100000000);
    $result = pg_execute($connection, "checkRecipeIDAvailable", $rand_id);
}

$result = pg_execute($connection, "checkExistingRecipies", array($_POST["recipeName"]));


if (pg_num_rows($result) > 0) {
    $_SESSION["error_message"] = "Recipe Name Already Taken";
    $location = $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/addRecipe.php");
} else {
    #   get user ID
    pg_prepare($connection, "userIDGet", "SELECT * FROM Users WHERE username = $1");
    $result = pg_execute($connection, "userIDGet", array($_SESSION["username"]));
    $userId = (int) (pg_fetch_result($result, 0, 0));

    #   recipes
    pg_prepare($connection, "recipeInsert", "INSERT INTO Recipes (recipe_id, author_id, recipe_name, recipe_url, meal_type) VALUES ($1, $2, $3, $4, $5)");
    $result = pg_execute($connection, "recipeInsert", array($rand_id, $userId, $_POST["recipeName"], $_POST["url"], $_POST["mealType"]));

    #   cuisine
    pg_prepare($connection, "cuisineInsert", "INSERT INTO Cuisine (cuisine_type) VALUES ($1)");
    pg_prepare($connection, "cuisineGet", "SELECT * FROM Cuisine WHERE cuisine_type = $1");
    $result = pg_execute($connection, "cuisineGet", array($_POST["cuisine"]));
    if (pg_num_rows($result) != 1) {
        $result = pg_execute($connection, "cuisineInsert", array($_POST["cuisine"]));
    }

    #   get recipe ID
    pg_prepare($connection, "recipeIDGet", "SELECT recipe_id FROM Recipes WHERE recipe_name = $1");
    $result = pg_execute($connection, "recipeIDGet", array($_POST["recipeName"]));
    $recipeId = pg_fetch_result($result, 0, 0);

    #   cuisine_recipes
    pg_prepare($connection, "cusineRecipeInsert", "INSERT INTO Cuisine_Recipes (cuisine_type, recipe_id) VALUES ($1, $2)");
    $result = pg_execute($connection, "cusineRecipeInsert", array($_POST["cuisine"], $recipeId));

    #   appliance
    $appliance_arr = explode(", ", $_POST["appliances"]);
    pg_prepare($connection, "applianceInsert", "INSERT INTO Appliance (appliance_name) VALUES ($1)");
    pg_prepare($connection, "applianceGet", "SELECT * FROM Appliance WHERE appliance_name = $1");
    foreach ($appliance_arr as &$appliance) {
        $result = pg_execute($connection, "applianceGet", array($appliance));
        if (pg_num_rows($result) != 1) {
            $result = pg_execute($connection, "applianceInsert", array($appliance));
        }
    }
    
    #   ingredient
    $ingredient_arr = explode(", ", $_POST["ingredients"]);
    pg_prepare($connection, "ingredientInsert", "INSERT INTO Ingredient (ingredient_name) VALUES ($1)");
    pg_prepare($connection, "ingredientGet", "SELECT * FROM Ingredient WHERE ingredient_name = $1");
    foreach ($ingredient_arr as &$ingredient) {
        $result = pg_execute($connection, "ingredientGet", array($ingredient));
        if (pg_num_rows($result) != 1) {
            $result = pg_execute($connection, "ingredientInsert", array($ingredient));
        }
    }

    #   ingredient_recipes
    pg_prepare($connection, "ingredientRecipeInsert", "INSERT INTO Ingredient_Recipes (ingredient_name, recipe_id) VALUES ($1, $2)");
    foreach ($ingredient_arr as &$ingredient) {
        $result = pg_execute($connection, "ingredientRecipeInsert", array($ingredient, $recipeId));
    }

    #   appliance_recipies
    pg_prepare($connection, "applianceRecipeInsert", "INSERT INTO Appliance_Recipes (appliance_name, recipe_id) VALUES ($1, $2)");
    foreach ($appliance_arr as &$appliance) {
        $result = pg_execute($connection, "applianceRecipeInsert", array($appliance, $recipeId));
    }

    #   Difficulty
    pg_prepare($connection, "userRecipeRating", "INSERT INTO Users_Recipes_Ratings (user_id, recipe_id, rating) VALUES ($1, $2, $3)");
    $result = pg_execute($connection, "userRecipeRating", array($userId, $recipeId, $_POST["difficulty"]));

    $location = $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/addRecipe.php");
}

pg_close($connection);

?>