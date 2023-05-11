<?php
session_start();
if (!isset($_SESSION["username"])) {
  $location = dirname($_SERVER["PHP_SELF"]);
  $_SESSION["redirect_requested"] = "remRecipe.php";
  header("Location: $location/login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
      <title>OpenFridge | Remove Recipe</title>
      <link rel="stylesheet" href="OF.css">

    </head>
    <body>
        <img src="logoCrop.png"/><br>
        <a href="logout.php"><button class="big">Logout</button></a>
        <a href="user.php"><button class="big">Search</button></a><br><br>
        <a href="addRecipe.php"><button class="big">Add Recipe</button></a>
        <a href="remRecipe.php"><button class="big">Remove Recipe</button></a>
        <form method="post" action="removeRecipeScript.php">
            <br><br>
            <label for="recipeName">Recipe name:</label><br>
            <input type="text" id="recipeName" name="recipeName"><br>
            <label for="author">Author name:</label><br>
            <input type="text" id="author" name="author"><br><br>
            <input type="submit" name="submit" value="Remove">
        </form>
        <p style="color: red;"><?php if (isset($_SESSION["error_message"])) {echo $_SESSION["error_message"]; unset($_SESSION["error_message"]); }?></p>
    </body>
</html>