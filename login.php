<?php
 // define variables and set to empty values
$username = $pwd =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = test_input($_POST["username"]);
  $pwd = test_input($_POST["password"]);
}

$user = 'root';
$password = 'root';
$db = 'course_registration';
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


  $sql = "SELECT u.Username, u.Category, u.Pwd, s.SID FROM user AS u LEFT OUTER JOIN user_student AS s ON u.Username = s.Username WHERE u.Username = '$username'";
  $record = mysqli_fetch_array(mysqli_query($conn, $sql));


  if(password_verify($pwd, $record["Pwd"])) {
    session_start();
	  $_SESSION['username'] = $username;
    $_SESSION['account'] = $record["Category"];
    $_SESSION['SID'] = $record["SID"];
	  header("Location: home.php");
  }
  else {
    $message = "Invalid username/password combination.";
    echo "<SCRIPT type='text/javascript'>
        alert('$message');
        window.location.replace(\"root.html\");
    </SCRIPT>";    
  }



 //clean input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>