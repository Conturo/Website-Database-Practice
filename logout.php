<?php
session_start(); // start (or resume) session
if (isset($_SESSION["error_message"])) {
    unset($_SESSION["error_message"]);
}
session_destroy();
$location = dirname($_SERVER["PHP_SELF"]);
header("Location: $location/index.html")
?>