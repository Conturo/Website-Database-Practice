<?php
session_start(); // start (or resume) session
session_destroy();
$location = dirname($_SERVER["PHP_SELF"]);
header("Location: $location/index.html")
?>