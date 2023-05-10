<?php
session_start();

$host = "localhost";
$port = "5432";
$user = "student";
$password = "CompSci364";
$db = "student";

$connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

$connection = pg_connect($connectionString);

pg_prepare($connection, "checkRecipe", "SELECT * FROM Recipe WHERE recipe_name = $1, ");
pg_prepare($connection, "removeRecipe", "SELECT * FROM Users WHERE username = $1");
?>