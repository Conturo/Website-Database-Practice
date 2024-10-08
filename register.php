<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>OpenFridge | Register</title>
        <link rel="stylesheet" href="OF.css">
        <script>
            function Validate_Info_Form_Data(){
                var errorsWithForm = false;
                let firstName = document.getElementById("firstName").value;
                let lastName = document.getElementById("lastName").value;
                let username = document.getElementById("username").value;
                let password = document.getElementById("password").value;
                document.getElementById("errorMsg").innerHTML = ""
                if (firstName==""){
                    document.getElementById("firstName").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("First name is a required field<br>");
                    errorsWithForm = true;
                }
                if (lastName==""){
                    document.getElementById("lastName").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("Last name is a required field<br>");
                    errorsWithForm = true;
                }
                if (username==""){
                    document.getElementById("username").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("Username is required<br>");
                    errorsWithForm = true;
                }
                if (password==""){
                    document.getElementById("password").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("Password is required<br>");
                    errorsWithForm = true;
                }
                var reName = /^[a-zA-Z\s\-]{1,50}$/;
                if (!reName.test(firstName)){
                    document.getElementById("firstName").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("First name must be less than 50 characters and consist only of letters, spaces, and hyphens<br>");
                    errorsWithForm = true;
                }
                if (!reName.test(lastName)){
                    document.getElementById("lastName").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("Last name must be less than 50 characters and consist only of letters, spaces, and hyphens<br>");
                    errorsWithForm = true;
                }
                var reUsername = /^[a-zA-Z0-9_]{1,50}$/;
                if(!reUsername.test(username) || username.length > 50){
                    document.getElementById("username").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("Username valid inputs contain letters, numbers, and underscores, and no longer than 50 characters<br>");
                    errorsWithForm = true;
                }
                if(password.length > 50 || password.length < 8){
                    document.getElementById("password").style.border = "maroon solid 3px";
                    document.getElementById("errorMsg").innerHTML += ("Password must be between 8 and 50 characters long<br>");
                    errorsWithForm = true;
                }
                return errorsWithForm;
            }
        </script>
    </head>
    <body>
        <img src="logoCrop.png"/><br>
        <a href="index.html"><button class="big">Home</button></a>
        <a href="login.php"><button class="big">Login</button></a>
    </body>
    <form method="post" onsubmit="return !Validate_Info_Form_Data()" action="registrationScript.php">
        <br><br><label for="firstName">First name:</label><br>
        <input type="text" id="firstName" name="firstName"><br>
        <label for="lastName">Last name:</label><br>
        <input type="text" id="lastName" name="lastName"><br>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Register">
    </form>
    <p style="color: red;" id = "errorMsg"></p>
    <p style="color: red;"><?php if (isset($_SESSION["error_message"])) {echo $_SESSION["error_message"]; unset($_SESSION["error_message"]); }?></p>
</html>