<?php
 // define variables and set to empty values
$username = $password = $account = $firstName = $lastName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = test_input($_POST["username"]);
  $password = test_input($_POST["password"]);
  $account = test_input($_POST["account"]);
  $firstName = test_input($_POST["firstName"]);
  $lastName = test_input($_POST["lastName"]);
}

session_start();
$_SESSION['username'] = $username;
header("Location: welcome.html");

 //clean input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

