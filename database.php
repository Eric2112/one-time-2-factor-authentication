<?php
// Get values the user enters
    $username = $_POST['user'];
    $password = $_POST['pass'];

// To prevent mysql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

// Connect and select databas
    mysql_connect("localhost", "root", "");
    mysql_select_db("BANK");

// Query the database for user
    $result = mysql_query("select * from users where username = '$username' and password = '$password'") or die ("Failed to query database" mysql_error());
    $row = mysql_fetch_array($result);
    if($row['username'] == $username && $row['password'] == $password){
            echo "Login succes! Welcome " $row['username'];
    } else{
        echo "Failed to login.";
    }
    ?>