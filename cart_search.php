<?php
session_start();

if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == ''))
{
  header("location: root.html");
  exit();
}
else
{
  $accountType = $_SESSION['account'];
  $SID = $_SESSION['SID'];
}

?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/class_search.css">
  <link rel="stylesheet" href="css/navbar.css">
</head>
<body>

<?php

$name = $_GET['name'];
$section = $_GET['section'];
$level = $_GET['level'];
$location = $_GET['location'];

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


$sql = "SELECT * FROM course c
        INNER JOIN course_professor cp ON c.CID = cp.CID
        INNER JOIN professor p ON p.PID = cp.PID
        INNER JOIN cart ca ON ca.CID = c.CID
        WHERE ";

if($SID != "")
{
  $sql .= "SID = '$SID' AND ";
}
else
{
  $sql .= "1 AND ";
}

if($name != "")
{
  $sql .= "Cname like '%$name%' AND ";
}
else
{
  $sql .= "1 AND ";
}

if($section != "")
{
  $sql .= "Section like '%$section%' AND ";
}
else
{
  $sql .= "1 AND ";
}

if($level != "any")
{
  $sql .= "level = '$level' AND ";
}
else
{
  $sql .= "1 AND ";
}

if($location == "any")
{
  $sql .= "1";
}
else if($location == 'online')
{
  $sql .= "Location = '$location'";
}
else
{
  $sql .= "Location != 'online'";
}

$sql .= " order by section asc";

$result = mysqli_query($conn, $sql);


if($accountType == 'student')
{
  echo "<table class='table table-striped'><tr><td>Class Section</td><td>Class Name</td><td>Professor</td><td>Day</td><td>Time</td><td>Location</td><td>Textbook</td><td>Fill</td><td>Enroll</td><td>Remove From Cart</td></tr>";
}

while($row = mysqli_fetch_array($result))
{
  $CID = $row["CID"];

	echo "<tr><td>". $row["Section"] . "</td><td>". $row["CName"].  "</td><td>". $row["FName"]. " ". $row["LName"] . "</td><td>". $row["Day"]. "</td><td>".$row["Time"]."</td><td>". $row["Location"]. "</td>";

  echo "<td><a href = 'image$CID.html'><img style = 'width: 50px; height: 75px;' src= 'images/$CID.jpg'></a></td>";

  if($row["OpenSeats"]==0)
  {
    echo "<td>FULL</td>";
  }
  else
  {
    echo "<td>OPEN</td>";
  }




  if($accountType == 'student')
  {
    echo "<td> <button onclick='enroll($CID)'>Enroll</button> </td></tr>";
    echo "<td> <button onclick='remove_from_cart($CID)'>Remove</button> </td>";
  }

}

echo "</table>";

mysqli_close($conn);

?>

</body>
</html>