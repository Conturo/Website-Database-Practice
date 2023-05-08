<?php
  session_start();
  // Replace these values with your database credentials
  $host = "localhost";
  $port = "5432";
  $dbname = "final_website";
  $user = "student";
  $password = "CompSci364";

  // Connect to the PostgreSQL database
  $connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
  $connection = pg_connect($connection_string);
  $statement = pg_prepare($connection, "user_password", "SELECT password_hash ".
                                      "FROM Users ".
                                      "WHERE username = $1;");
  $error = false;
  $username = $_POST["username"];
  $result = pg_execute($connection, "user_password", array($username));
  if (pg_num_rows($result) > 0) {
    // Get the password hash from the query result
    $row = pg_fetch_assoc($result);
    $password_hash = $row["password_hash"];
  }
  if (password_verify($_POST["password"], $password_hash)){
    $_SESSION["username"] = $_POST["username"];
  }
  $location = dirname($_SERVER["PHP_SELF"]);
  // Close the database connection
  if (isset($_SESSION["username"])) { // authenticated
    if (isset($_REQUEST["redirect"])) {
      $location = $_REQUEST["redirect"];
    }
  
    // redirect to requested page
    header("Location: $location/user.html");
  }
  else{
    $_SESSION["error_message"] = "Incorrect username or password";
    header("Location: $location/login.html");
    $error = true;
  }

  pg_close($connection);
 ?>