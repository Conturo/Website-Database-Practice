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
        <a href="addReview.php"><button class="big">Leave a Review</button></a>
        <a href="viewReview.php"><button class="big">View Reviews</button></a><br><br>
        <a href="addRecipe.php"><button class="big">Add Recipe</button></a>
        <a href="remRecipe.php"><button class="big">Remove Recipe</button></a><br><br>
        <a href="logout.php"><button class="big" action="logout.php">Logout</button></a>
        <a href="user.php"><button class="big">Search</button></a>

        <form method="post" action="viewReviewScript.php">
            <br><br>
            <label for="recipeSearch">Recipe name:</label><br>
            <input type="text" id="recipeSearch" name="recipeSearch"><br><br>
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
        <?php if(isset($_SESSION["reviews"])){echo $_SESSION["reviews"]; unset($_SESSION["reviews"]);} ?>
    </body>
</html>