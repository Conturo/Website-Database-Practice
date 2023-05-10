<?php
session_start();
if (!isset($_SESSION["username"])) {
  $location = dirname($_SERVER["PHP_SELF"]);
  $_SESSION["redirect_requested"] = "user.php";
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
        <a href="logout.php"><button class="big" action="logout.php">Logout</button></a>
        <a href="user.php"><button class="big">Search</button></a><br><br>
        <a href="addRecipe.php"><button class="big">Add Recipe</button></a>
        <a href="remRecipe.php"><button class="big">Remove Recipe</button></a>
        <form method="post" action="basicSearchScript.php">
            <br><br>
            <label for="keyword">Keyword:</label><br>
            <input type="text" id="keyword" name="keyword"><br><br>
            <input type="submit" name="submit" value="Search">
        </form>
        <br><br>
        <a href="advancedSearch.php" ><button class="small">Advanced Search Options</button></a>
    </body>
</html>