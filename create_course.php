<?php
session_start();

$className = $_GET["className"];
$section = $_GET["section"];
$term = $_GET["term"];
$year = $_GET["year"];
$professorFirstName = $_GET["professorFirstName"];
$professorLastName = $_GET["professorLastName"];
$dayVal = $_GET["days"];
$day = "";
if($dayVal === "Mon") {
  $day = "Mon&Wed";
}
else {
  $day = "Tue&Thu";
}
$time = $_GET["time"];
$level = $_GET["level"];
$location = $_GET["location"];
$seats = $_GET["seats"];

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


//Check if section exists already


//Check if professor teaches a section at this schedule already


//Check if professor exists already
$sql = "SELECT * FROM professor WHERE FName = '$professorFirstName' AND LName = '$professorLastName'";
$result = mysqli_query($conn, $sql);
$row_cnt = $result->num_rows;

//Insert new professor
if($row_cnt == 0)
{
  $sql = "INSERT INTO professor (FName, LName, Email)
          VALUES ('$professorFirstName', '$professorLastName', '$professorFirstName$professorLastName@utdallas.edu')";
  if ($conn->query($sql) === TRUE)
  {
    echo "New Professor Added Successfully\n";
  }
  else
  {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

//Insert into courses
$sql = "INSERT INTO Course (Section, CName, Semester, Year, Day, Time, Location, OpenSeats, Level)
        VALUES ('$section', '$className', 'Spring', '$year', '$day', '$time', '$location', '$seats', '$level')";

if ($conn->query($sql) === TRUE)
{
  echo "Course Added Successfully\n";
}
else
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}


//Get PID
$sql = "SELECT *
        FROM professor
        WHERE FName = '$professorFirstName' AND LName = '$professorLastName'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
  $PID = $row["PID"];
}

//Get CID
$sql = "SELECT CID FROM course ORDER BY CID DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
  $CID = $row["CID"];
}

//Insert into course_professor
$sql = "INSERT INTO course_professor (CID, PID)
        VALUES ($CID, $PID)";

if ($conn->query($sql) === TRUE)
{
  echo "Course_Professor Added Successfully\n";
}
else
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}





?>
