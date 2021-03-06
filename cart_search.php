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
   <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
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
        INNER JOIN department d ON c.DID = d.DID
        INNER JOIN textbook tb ON tb.CID = c.CID
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
  echo "<table class='table'><tr><td>Department</td><td>Course Number</td><td>Section Number</td><td>Class Name</td><td>Professor</td><td>Day</td><td>Time</td><td>Location</td><td>Textbook</td><td>Fill</td><td>Enroll</td><td>Remove From Cart</td></tr>";
}
else {
  echo "<table class='table'><tr><td>Department</td><td>Course Number</td><td>Section Number</td><td>Class Name</td><td>Professor</td><td>Day</td><td>Time</td><td>Location</td><td>Textbook</td><td>Fill</td></tr>";
}

while($row = mysqli_fetch_array($result))
{
  $CID = $row["CID"];
  $Src = $row["Src"];

  echo "<tr><td>".$row["DName"]."</td><td>".$row["CNumber"]."</td><td>". $row["Section"] . "</td><td>". $row["CName"].  "</td><td>". $row["FName"]. " ". $row["LName"] . "</td><td>". $row["Day"]. "</td><td>".$row["Time"]."</td><td>". $row["Location"]. "</td>";

  echo "<td><a href = 'show_textbook_image.php?Src=$Src'><img style = 'width: 60px; height: 75px;' src= 'images/$Src'></a></td>";

  if($row["Quota"] === $row["EnrolledSeats"])
  {
    echo "<td>FULL</td>";
  }
  else
  {
    echo "<td>OPEN</td>";
  }

  if($accountType == 'student')
  {
    echo "<td> <button onclick='enroll($CID)'>Enroll</button></td>";
    echo "<td> <button onclick='remove_from_cart($CID)'>Remove</button></td>";
  }
  echo "</tr>";
}

echo "</table>";

mysqli_close($conn);

?>

</body>
</html>
