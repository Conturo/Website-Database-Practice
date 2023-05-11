<?php
session_start();

$host = "localhost";
$port = "5432";
$user = "student";
$password = "CompSci364";
$db = "student";

if (!isset($_SESSION["username"]) && isset($_POST["username"]) && isset($_POST["password"])) {

  $_SESSION["error_message"] = "";

  $connectionString = "host=$host port=$port dbname=$db user=$user password=$password";

  $connection = pg_connect($connectionString);

  pg_prepare($connection, "unameQuery", "SELECT password_hash ".
                                                  "FROM Users ".
                                                  "WHERE username = $1;");

  $result = pg_execute($connection, "unameQuery", array($_POST["username"]));

  if (!$result) {
      echo "Error";
  } else if (pg_num_rows($result) < 1) {
      echo "Username Not Found!";
  }else {
    $passwordHash = pg_fetch_result($result, 0, 0);
  }

  if (password_verify($_POST["password"], $passwordHash)){
      $_SESSION["username"] = $_POST["username"];
  }
}

if (isset($_SESSION["username"])) {
    if (isset($_SESSION["redirect_requested"])) {
      $location = dirname($_SERVER["PHP_SELF"])."/".$_SESSION["redirect_requested"];
      unset($_SESSION["redirect_requested"]);
    } else {
      $location = dirname($_SERVER["PHP_SELF"])."/user.php";
    }
  
    header("Location: $location");
  }
  else{
    $_SESSION["error_message"] = "Incorrect username or password";
    $location = dirname($_SERVER["PHP_SELF"]);
    header("Location: $location/login.php");
  }

  pg_close($connection);

  ?>