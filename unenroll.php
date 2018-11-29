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

$sql = "DELETE FROM student_course WHERE SID = $SID and CID = $CID";
if ($conn->query($sql) === TRUE)
{
  echo "Unenrolled from course!";
}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}


$enrollmentQuery = "SELECT EnrolledSeats FROM course WHERE CID = $CID";
$sql = mysqli_query($conn, $enrollmentQuery);
$row = mysqli_fetch_array($sql);
$newEnrollmentTotal = (int) $row["EnrolledSeats"] - 1;

$sql = "UPDATE course SET EnrolledSeats = '$newEnrollmentTotal' WHERE CID = $CID";
if ($conn->query($sql) === TRUE){
}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}

?>