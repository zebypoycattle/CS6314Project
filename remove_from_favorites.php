<?php
session_start();

if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == ''))
{
  header("location: root.html");
  exit();
}

//Get parameters
$SID = $_SESSION["SID"];
$CID = $_GET["CID"];

$user = 'root';
$password = 'root';
$db = 'course_registration';
$host = 'localhost';
$port = 3306;

$conn = mysqli_connect(
   $host,
   $user,
   $password,
   $db,
   $port
);

if (!$conn)
{

	echo "Connection failed!";
	exit;
}

$sql = "DELETE FROM favorites WHERE SID = $SID and CID = $CID";
if ($conn->query($sql) === TRUE)
{
  echo "Course Deleted From Favorites!";
}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}