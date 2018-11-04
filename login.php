<?php
 // define variables and set to empty values
$username = $pwd =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = test_input($_POST["username"]);
  $pwd = test_input($_POST["password"]);
}

$user = 'root';
$password = 'root';
$db = 'hw3';
$host = 'localhost';
$port = 3306;

$conn = mysqli_init();
$conn = mysqli_connect(
   $host,
   $user,
   $password,
   $db,
   $port
);

  if (!$conn) {
    echo "Connection failed!";
    exit;
  }



  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  $result = mysqli_query($conn, $sql);
  mysqli_close();

  if(mysqli_num_rows($result) != 1) {
    session_start();
	$_SESSION['username'] = $username;
	header("Location: welcome.html");
  }
  else{
    header("Location: home.html");
  }



 //clean input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>