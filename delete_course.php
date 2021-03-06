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
    echo "Course deleted from all carts"."\n";
}
else
{
    echo "Error deleting record: " . $conn->error ."\n";
}

$sql = "DELETE FROM course_professor WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{
    echo "Course deleted from course_professor"."\n";
}
else
{
    echo "Error deleting record: " . $conn->error . "\n";
}

$sql = "DELETE FROM favorites WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{
    echo "Course deleted from favorites"."\n";
}
else
{
    echo "Error deleting record: " . $conn->error. "\n";
}
$sql = "DELETE FROM student_course WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{
    echo "Course deleted from student_course"."\n";
}
else
{
    echo "Error deleting record: " . $conn->error."\n";
}

$sql = "DELETE FROM textbook WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{
    echo "Course deleted from textbook"."\n";
}
else
{
    echo "Error deleting record: " . $conn->error. "\n";
}

$sql = "UPDATE course
        SET IsDeleted = 1
        WHERE CID = $CID";
if ($conn->query($sql) === TRUE)
{
    echo "Successful soft delete from course"."\n";
}
else
{
    echo "Error deleting record: " . $conn->error."\n";
}

?>
