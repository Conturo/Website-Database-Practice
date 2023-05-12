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

    $search = "%".$_POST["keyword"]."%";
    pg_prepare($connection, "searchQuery", "SELECT DISTINCT recipe_name,meal_type,first_name,last_name,recipe_url,ROUND(AVG(rating),2) AS average_rating FROM recipes NATURAL JOIN appliance_recipes NATURAL JOIN cuisine_recipes NATURAL JOIN ingredient_recipes NATURAL JOIN users_recipes_ratings LEFT JOIN Users ON recipes.author_id=users.user_id WHERE recipe_name ILIKE $1 OR meal_type ILIKE $1 OR appliance_name ILIKE $1 OR cuisine_type ILIKE $1 OR ingredient_name ILIKE $1 GROUP BY recipe_name, meal_type, recipe_url,users.first_name,users.last_name;");

    $result = pg_execute($connection, "searchQuery", array($search));
    $tableString = "";
    if (pg_num_rows($result) > 0) {
        $row = 0;

        while ($row_data = pg_fetch_row($result)) {
            $twodarray[$row] = $row_data;
            $row++;
        }
        $tableString = "<table>\n<tr><th>Recipe Name</th><th>Meal</th><th>Author First Name</th><th>Author Last Name</th><th>URL</th><th>Avg Rating</th></tr>\n";

        foreach ($twodarray as $row) {
            $tableString .= "<tr>";
            foreach ($row as $cell) {
                $tableString .= "<td>" . $cell . "</td>";
            }
            $tableString .= "</tr>\n";
        }

        $tableString .= "</table>\n";
    }
    $_SESSION["recipes"] = $tableString;
    pg_close($connection);

    $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/user.php");

  ?>