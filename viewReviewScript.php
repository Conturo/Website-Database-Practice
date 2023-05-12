<?php
    session_start();

    $host = "localhost";
    $port = "5432";
    $user = "student";
    $password = "CompSci364";
    $db = "student";

    $twodarray = array();

    $connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

    $connection = pg_connect($connectionString);

    pg_prepare($connection, "searchQuery", "SELECT DISTINCT first_name,last_name,rating,review_text FROM Users NATURAL JOIN users_recipes_reviews NATURAL JOIN users_recipes_ratings NATURAL JOIN recipes WHERE recipe_name ILIKE $1;");

    $result = pg_execute($connection, "searchQuery", array($_POST["recipeSearch"]));

    $tableString = "empty";
    if (pg_num_rows($result) > 0) {
        $row = 0;

        while ($row_data = pg_fetch_row($result)) {
            $twodarray[$row] = $row_data;
            $row++;
        }
        $tableString = "<table>\n<tr><th>Reviewer First Name</th><th>Reviewer Last Name</th><th>Rating</th><th>Review</th></tr>\n";

        foreach ($twodarray as $row) {
            $tableString .= "<tr>";
            foreach ($row as $cell) {
                $tableString .= "<td>" . $cell . "</td>";
            }
            $tableString .= "</tr>\n";
        }

        $tableString .= "</table>\n";
    }
    $_SESSION["reviews"] = $tableString;
    pg_close($connection);

    $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/viewReview.php");

  ?>