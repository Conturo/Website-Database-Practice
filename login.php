<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>OpenFridge | Login</title>
        <link rel="stylesheet" href="OF.css">
        <script>
            function Validate_Info_Form_Data(){
                var errorsWithForm = false;
                let username = document.getElementById("username").value;
                let password = document.getElementById("password").value;
                document.getElementById("errorMsg").innerHTML = ""
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
                return errorsWithForm;
            }
        </script>
    </head>
    <body>
        <img src="logoCrop.png"/><br>
        <a href="logout.php"><button class="big">Home</button></a>
        <a href="register.php"><button class="big">Register</button></a>

    </body>
    <form method="post" onsubmit="return !Validate_Info_Form_Data()" action="authenticate.php">
        <br><br><label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
    <p style="color: red;"><?php if (isset($_SESSION["error_message"])) {echo $_SESSION["error_message"]; unset($_SESSION["error_message"]); }?></p>
</html>