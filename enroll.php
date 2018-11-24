<?php
session_start();

if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == ''))
{
  header("location: root.html");
  exit();
}
//Get parameters
$username = $_SESSION["username"];
$account_type = $_SESSION['account'];
$SID = $_SESSION['SID'];
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

if (!$conn){

	echo "Connection failed!";
	exit;
}

//Get enrollment records with this SID
$sql = "SELECT * FROM Student_Course WHERE SID=" . $SID . " AND CID=" . $CID;
$result = mysqli_query($conn, $sql);
$row_cnt = $result->num_rows;

//Check to see if this class is already enrolled
if($row_cnt == 1)
{
  echo "You've already enrolled this course!";
}
else
{

  $sql = "INSERT INTO Student_Course (SID, CID)
          VALUES ('$SID', '$CID')";

  if ($conn->query($sql) === TRUE)
  {
    echo "Course Successfully Enrolled!";
  }
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $sql = "DELETE FROM cart WHERE SID = $SID and CID = $CID";

  if ($conn->query($sql) === TRUE)
  {
    echo "Course No Longer in Cart!";
  }
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

?>