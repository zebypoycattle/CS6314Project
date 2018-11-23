<?php
 // define variables and set to empty values
$username = $pwd = $category = $account = $email = $firstName = $lastName = $studentID = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = test_input($_POST["username"]);
  $pwd = test_input($_POST["password"]);
  $account = test_input($_POST["account"]);
  $firstName = test_input($_POST["firstName"]);
  $lastName = test_input($_POST["lastName"]);
  $email = test_input($_POST["email"]);
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


if($account !== "admin") {
	$category = "student";
	$largestStudentID = "SELECT SID FROM user_student ORDER BY SID DESC LIMIT 1";
	$sql = mysqli_query($conn, $largestStudentID);
	$row = mysqli_fetch_array($sql);
	$studentID = (int) $row["SID"] + 1;

	$registerUserStudent = "INSERT INTO user_student(Username, SID) VALUES ('$username', '$studentID')";
	mysqli_query($conn, $registerUserStudent);

  $registerStudent = "INSERT INTO student(SID, FName, LName, Email, Degree) VALUES ('$studentID', '$firstName', '$lastName', $email, $account)";
  mysqli_query($conn, $registerStudent);

}
else {
	$category = $account;
}


$hash = password_hash($pwd, PASSWORD_DEFAULT);
$registerAccount = "INSERT INTO user(Username, Category, Pwd) VALUES ('$username', '$category', '$hash')";
mysqli_query($conn, $registerAccount);

mysqli_close();

session_start();
$_SESSION['username'] = $username;
$_SESSION['account'] = $category;
$_SESSION['SID'] = $studentID;

header("Location: home.php");



 //clean input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

