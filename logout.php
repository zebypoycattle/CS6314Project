<?php
session_start();
//check if user logged in
if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == '')) {
  header("location: root.html");
  exit();
}

//unset session variables
unset($_SESSION["name"]);

//destroy session
session_destroy();
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/style.css">
    <title>Logout</title>
  </head>
  <body>
    <h1>You are now logged out.</h1>
    <h1><a href="root.html">Return to login page</a></h1>
  </body>
</html>