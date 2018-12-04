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

//Get cart records with this SID and this CID
$sql = "SELECT * FROM Cart WHERE SID=" . $SID . " AND CID=" . $CID;
$result = mysqli_query($conn, $sql);
$row_cnt = $result->num_rows;

$sql = "SELECT * FROM favorites WHERE SID=" . $SID . " AND CID=" . $CID;
$result = mysqli_query($conn, $sql);
$row_cnt2 = $result->num_rows;

//Check to see if this class already in cart
if($row_cnt == 1)
{
  echo "This course is already in your cart!";
}
else
{

  $sql = "INSERT INTO Cart (SID, CID)
          VALUES ('$SID', '$CID')";

  if ($conn->query($sql) === TRUE)
  {
    echo "Course Added To Cart!";
  }
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  if ($row_cnt2 == 1) {
    $sql = "DELETE FROM favorites WHERE SID = $SID and CID = $CID";

    if ($conn->query($sql) === TRUE)
    {
      echo "Course No Longer in Favorites!";
    }
    else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

?>