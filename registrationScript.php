<?php
session_start();

$host = "localhost";
$port = "5432";
$user = "student";
$password = "CompSci364";
$db = "student";

$connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

$connection = pg_connect($connectionString);

pg_prepare($connection, "checkUserAvailable", "SELECT * FROM Users WHERE username = $1");
pg_prepare($connection, "checkUserIDAvailable", "SELECT * FROM Users WHERE user_id = $1");
pg_prepare($connection, "userInsert", "INSERT INTO Users (user_id, username, password_hash, first_name, last_name) VALUES ($1, $2, $3, $4, $5)");

$rand_id = rand(1, 100000000);

$args = array($rand_id, $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["firstName"], $_POST["lastName"]);
$result = pg_execute($connection, "checkUserIDAvailable", $rand_id);

while (pg_num_rows($result) != 0) {
    $rand_id = rand(1, 100000000);
    $result = pg_execute($connection, "checkUserIDAvailable", $rand_id);
}

$result = pg_execute($connection, "checkUserAvailable", array($_POST["username"]));

if (!strcmp(pg_fetch_result($result, 0, 1), $_POST["username"])) {
    $_SESSION["error_message"] = "Username Already Taken";
    $location = $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/register.php");
} else {
    $result = pg_execute($connection, "userInsert", $args);

    if (!$result) {
        echo "Error";
    } else if (pg_num_rows($result) < 1) {
        echo "No Results Found!";
    }

    unset($_SESSION["error_message"]);
    $location = $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/login.php");
}


pg_close($connection);

?>