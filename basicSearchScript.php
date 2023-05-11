<?php
session_start();

$host = "localhost";
$port = "5432";
$user = "student";
$password = "CompSci364";
$db = "student";

$connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

$connection = pg_connect($connectionString);

pg_prepare($connection, "keywordNameSearch", "SELECT * FROM Recipes WHERE recipe_name LIKE $1");

$recipeNameResult = pg_execute($connection, "keywordNameSearch", array("%".$_POST["keyword"]."%"));

echo pg_fetch_row($recipeNameResult, 0)[2];


pg_close($connection);

?>