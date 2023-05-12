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
      <title>OpenFridge | Add Recipe</title>
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
        <form method="post" action="addReviewScript.php">
            <br><br>
            <label for="recipeName">Recipe name:</label><br>
            <input type="text" id="recipeName" name="recipeName"><br><br>
            <label for="rating">Rating:</label><br>
            <select id="rating" name="rating">
                <option value="one">1</option>
                <option value="two">2</option>
                <option value="three">3</option>
                <option value="four">4</option>
                <option value="five">5</option>
            </select><br><br>
            <label for="review">Review:</label><br>
            <input type="text" id="review" name="review"><br><br>

            <input type="submit" name="submit" value="Submit">
        </form>
        <p style="color: red;"><?php if (isset($_SESSION["message"])) {echo $_SESSION["message"]; unset($_SESSION["message"]); }?></p>
    </body>
</html>