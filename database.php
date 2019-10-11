<?php
session_start();

//connect to database
$db = mysqli_connect("127.0.0.1", "marina", "marinapass", "bank");

if(isset($_POST['login_btn'])){
    $username = mysql_real_escape_string ($_POST['username']);
    $password = mysql_real_escape_string ($_POST['password']);

    $sql = "select * from users where username = '$username' and password = '$password'";
    $result = mysqli_query($db, $sql);

    if(mysqli_num_rows($result)==1){
        $_SESSION['message'] = "You are now logged in";
        $_SESSION['username'] = $username;
        header("location: home.html");
    } else{
        $_SESSION['message']= "Username/Password combination incorrect";
    }
}
    ?>

<!DOCTYPE html>
<html>
<head>
    <title> Login Page</title>
    <link rel ="stylesheet" type ="text/css" href ="style.css">
</head>
<body>
    <div class ="header">
            <h1>Register, login and logout user php mysql</h1>
    </div>

    <form method = "post" action= "database.php">
            <table>
                <tr>
                <td> Username:</td>
                <td><input type = "text" id = "username" class = "textInput"></td>
            </tr>
            <tr>
                <td> Password:</td>
                <td><input type = "password" id = "password" class = "textInput"></td>
            </tr>
            <tr>
            <td></td>
                <td><input type = "submit" name = "login_btn" value = "Login"></td>
            </tr>
        </table>
    </form>
</body>
</html>