<?php
session_start();

if (!isset($_SESSION["username"])) {
  $location = dirname($_SERVER["PHP_SELF"]);
  $_SESSION["redirect_requested"] = "addRecipe.php";
  header("Location: $location/login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
      <title>OpenFridge | Add Recipe</title>
      <link rel="stylesheet" href="OF.css">

    </head>
    <body>
        <img src="logoCrop.png"/><br>
        <a href="logout.php"><button class="big">Logout</button></a>
        <a href="user.php"><button class="big">Search</button></a><br><br>
        <a href="addRecipe.php"><button class="big">Add Recipe</button></a>
        <a href="remRecipe.php"><button class="big">Remove Recipe</button></a>
        <form method="post" action="addRecipeScript.php">
            <br><br>
            <label for="recipeName">Recipe name:</label><br>
            <input type="text" id="recipeName" name="recipeName"><br>
            <label for="url">URL:</label><br>
            <input type="text" id="url" name="url"><br>
            <label for="mealType">Meal Type (Breakfast, Lunch, Dinner):</label><br>
            <input type="text" id="mealType" name="mealType"><br>
            <label for="cuisine">Cuisine:</label><br>
            <input type="text" id="cuisine" name="cuisine"><br>
            <label for="ingredients">Ingredients (comma delimited):</label><br>
            <input type="text" id="ingredients" name="ingredients"><br>
            <label for="appliances">Appliances Required (comma delimited):</label><br>
            <input type="text" id="appliances" name="appliances"><br><br>
            <input type="submit" name="submit" value="Add">
        </form>
        <p style="color: red;"><?php if (isset($_SESSION["error_message"])) {echo $_SESSION["error_message"]; unset($_SESSION["error_message"]); }?></p>
    </body>
</html>