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
    $recipeName = $_POST['recipeName'];
    $authorName = $_POST['author'];
    $cuisine = $_POST['cuisine'];
    $ingredient = $_POST['ingredients'];
    
    $sql = "SELECT DISTINCT recipe_name,meal_type,recipe_url,ROUND(AVG(rating),2) AS average_rating FROM recipes NATURAL JOIN appliance_recipes NATURAL JOIN cuisine_recipes NATURAL JOIN ingredient_recipes NATURAL JOIN users_recipes_ratings WHERE 1=1";
    if (!empty($recipeName)) {
        $sql .= " AND recipe_name ILIKE '%" . pg_escape_string($recipeName) . "%'";
    }
    
    if (!empty($authorName)) {
        $sql .= " AND author_name ILIKE '%" . pg_escape_string($authorName) . "%'";
    }
    
    if (!empty($cuisine)) {
        $sql .= " AND cuisine_type ILIKE '%" . pg_escape_string($cuisine) . "%'";
    }
    
    if (!empty($ingredient)) {
        $sql .= " AND ingredient_name ILIKE '%" . pg_escape_string($ingredient) . "%'";
    }
    $sql .= "GROUP BY recipe_name,meal_type,recipe_url;";
    $result = pg_query($connection, $sql);
    error_log($sql,0);
    $tableString = "";
    if (pg_num_rows($result) > 0) {
        $row = 0;

        while ($row_data = pg_fetch_row($result)) {
            $twodarray[$row] = $row_data;
            $row++;
        }
        $tableString = "<table>\n<tr><th>Recipe Name</th><th>Meal</th><th>URL</th></tr>\n";

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
    header("Location: $location/advancedSearch.php");

  ?>