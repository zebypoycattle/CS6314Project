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

//Get favorites records with this SID
$sql = "SELECT * FROM Favorites WHERE SID=" . $SID . " AND CID=" . $CID;
$result = mysqli_query($conn, $sql);
$row_cnt = $result->num_rows;

//Check to see if this class already in favorites
if($row_cnt == 1)
{
  echo "This course is already in your favorites!";
}
else
{

  $sql = "INSERT INTO Favorites (SID, CID)
          VALUES ('$SID', '$CID')";

  if ($conn->query($sql) === TRUE)
  {
    echo "Course Added To Favorites!";
  }
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

?>