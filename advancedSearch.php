<?php
session_start();
if (!isset($_SESSION["username"])) {
  $location = dirname($_SERVER["PHP_SELF"]);
  $_SESSION["redirect_requested"] = "advancedSearch.php";
  header("Location: $location/login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
      <title>OpenFridge | Search</title>
      <link rel="stylesheet" href="OF.css">

    </head>
    <body>
        <img src="logoCrop.png"/><br>
        <a href="logout.php"><button class="big">Logout</button></a>
        <a href="user.php"><button class="big">Search</button></a><br><br>
        <a href="addRecipe.php"><button class="big">Add Recipe</button></a>
        <a href="remRecipe.php"><button class="big">Remove Recipe</button></a>
        <form method="post" action="advSearchScript.php">
            <br><br>
            <label for="recipeName">Recipe name:</label><br>
            <input type="text" id="recipeName" name="recipeName"><br>
            <label for="author">Author name:</label><br>
            <input type="text" id="author" name="author"><br>
            <label for="cuisine">Cuisine:</label><br>
            <input type="text" id="cuisine" name="cuisine"><br>
            <label for="ingredients">Ingredient:</label><br>
            <input type="text" id="ingredients" name="ingredients"><br><br>
            <input type="submit" name="submit" value="Search">
        </form>
        <br><br>
        <style>
          table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            margin-left: auto;
            margin-right: auto;
		        }
	      </style>
        <?php if(isset($_SESSION["recipes"])){echo $_SESSION["recipes"];} ?>
    </body>
</html>