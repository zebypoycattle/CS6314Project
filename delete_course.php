<?php
session_start();

if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == ''))
{
  header("location: root.html");
  exit();
}

//Get parameters
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

$sql = "DELETE FROM cart WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{

}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}

$sql = "DELETE FROM course WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{

}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}
$sql = "DELETE FROM course_professor WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{

}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}
$sql = "DELETE FROM favorites WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{

}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}
$sql = "DELETE FROM student_course WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{

}
else
{
    echo "Error deleting record: " . $conn->error;
    exit();
}
echo "Course Deleted Successfully!";

?>
