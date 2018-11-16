<?php
session_start();

//Get parameters
$username = $_SESSION["username"];
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

//Get SID from username
$sql = "SELECT * FROM user_student WHERE Username = '" . $username . "'";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result))
{
  $SID = $row["SID"];
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
