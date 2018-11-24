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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Logout</title>
  </head>
  <body>
    <br><br>
    <h1>You are now logged out.</h1>
    <h1><a href="root.html">Return to login page</a></h1>
  </body>
</html>