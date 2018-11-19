<?php
 if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == '')) {
    header("location: root.html");
    exit();
  }
  else {
    session_start();
    $username = $_SESSION['username'];  
  }
echo "<br>";
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php

$name = $_GET['name'];
$section = $_GET['number'];
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
        WHERE ";

if($name != "")
{
  $sql .= "Cname like '%" . $name . "%' AND ";
}
else
{
  $sql .= "1 AND ";
}

if($section != "")
{
  $sql .= "Section like '%" . $section . "%' AND ";
}
else
{
  $sql .= "1 AND ";
}

if($level != "any")
{
  $sql .= "level = '" . $level . "' AND ";
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
  $sql .= "Location = '" . $location . "'";
}
else
{
  $sql .= "Location != 'online'";
}

$sql .= " order by section asc";

$result = mysqli_query($conn, $sql);

echo "<table class='table table-striped'><tr><td>Class Section</td><td>Class Name</td><td>Professor</td><td>Time</td><td>Location</td><td>Fill</td><td>Add To Favorites</td></tr>";

while($row = mysqli_fetch_array($result))
{
	echo "<tr><td>". $row["Section"] . "</td><td>". $row["CName"].  "</td><td>". $row["FName"]. " ". $row["LName"] . "</td><td>". $row["Schedule"]. "</td><td>". $row["Location"]. "</td>";
  if($row["OpenSeats"]==0)
  {
    echo "<td>FULL</td>";
  }
  else
  {
    echo "<td>OPEN</td>";
  }

  echo "<td> <button onclick='add_to_favorites(" . $row["CID"] . ")'>Add</button> </td></tr>";


}

echo "</table>";

mysqli_close($conn);

?>


</body>
</html>
