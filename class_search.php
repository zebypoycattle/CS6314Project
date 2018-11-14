<?php
session_start();
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php

$name = $_GET['name'];
$number = $_GET['number'];
$level = $_GET['level'];
$location = $_GET['location'];

$user = 'root';
$password = 'root';
$db = 'courses';
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

$sql = "SELECT * FROM classes WHERE ";

if($name != "")
{
  $sql .= "name like '%" . $name . "%' AND ";
}
else
{
  $sql .= "1 AND ";
}

if($number != "")
{
  $sql .= "number = " . $number . " AND ";
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

if($location != "any")
{
  $sql .= "location = '" . $location . "'";
}
else
{
  $sql .= "1";
}

$sql .= " order by section asc";

$result = mysqli_query($conn, $sql);

echo "<table class='table table-striped'><tr><td>Section</td><td>Class Number</td><td>Class Title</td><td>Instructor</td><td>Time</td><td>Location</td><td>Fill</td><td>Add To Cart</td></tr>";

while($row = mysqli_fetch_array($result))
{
	echo "<tr><td>". $row["section"] . "</td><td>". $row["number"]. "</td><td>". $row["name"]. "</td><td>". $row["professor"]. "</td><td>". $row["time"]. "</td><td>". $row["location"]. "</td>";
  if($row["open_seats"]==0)
  {
    echo "<td>FULL</td>";
  }
  else
  {
    echo "<td>OPEN</td>";
  }
  $link = 'http://localhost:8888/cart.php?number=' . $row["number"];
  echo "<td><a href=" . $link . ">Add To Cart</a></td></tr>";
}

echo "</table>";

mysqli_close($conn);

?>


</body>
</html>
