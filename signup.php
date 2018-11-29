<?php
 // define variables and set to empty values
$username = $pwd = $category = $account = $dept = $email = $firstName = $lastName = $studentID = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = test_input($_POST["username"]);
  $pwd = test_input($_POST["password"]);
  $account = test_input($_POST["account"]);
  $firstName = test_input($_POST["firstName"]);
  $lastName = test_input($_POST["lastName"]);
  $email = test_input($_POST["email"]);
  $dept = test_input($_POST["department"]);
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


if($account !== "Admin") {
	$category = "student";
	$largestStudentID = "SELECT SID FROM user_student ORDER BY SID DESC LIMIT 1";
	$sql = mysqli_query($conn, $largestStudentID);
	$row = mysqli_fetch_array($sql);
	$studentID = (int) $row["SID"] + 1;

	$registerUserStudent = "INSERT INTO user_student(Username, SID, Degree, DID) VALUES ('$username', '$studentID', '$account', '$dept')";
	mysqli_query($conn, $registerUserStudent);

}
else {
	$category = "admin";
}


$hash = password_hash($pwd, PASSWORD_DEFAULT);
$registerAccount = "INSERT INTO user(Username, Category, Pwd, Fname, LName, Email) VALUES ('$username', '$category', '$hash', '$firstName', '$lastName', '$email')";
mysqli_query($conn, $registerAccount);
mysqli_close();

$message = "Account successfully created.";
header("Location: home.php?message=" .urlencode($message));



 //clean input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

