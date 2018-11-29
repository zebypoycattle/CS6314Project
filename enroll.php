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

// echo "SID: " . $SID . " CID: " . $CID;
//Get enrollment records with this SID and this CID
$sql = "SELECT * FROM Student_Course WHERE SID=" . $SID . " AND CID=" . $CID;
$result = mysqli_query($conn, $sql);
$row_cnt = $result->num_rows;

// get student's degree
$sql = "SELECT * FROM User_Student WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$degree = $row["Degree"];

$sql = "SELECT * FROM Course AS c WHERE CID = " . $CID;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$day = $row["Day"];
$time = $row["Time"];
$level = $row["Level"];
$EnrolledSeats = $row["EnrolledSeats"];
$Quota = $row["Quota"];

// Get enrollment records with this SID in current semester
$sql = "SELECT * FROM Course AS c INNER JOIN Term AS t ON c.Semester = t.Semester AND c.Year = t.Year INNER JOIN Student_Course AS sc ON c.CID = sc.CID WHERE sc.SID = " . $SID . " AND t.currentTermToRegister = 1";
$result = mysqli_query($conn, $sql);
$row_cnt2 = $result->num_rows;

//Check to see if this class is already enrolled
if($row_cnt == 1)
{
  echo "You've already enrolled this course!";
}
else if ($degree == "undergraduate" and $row_cnt2 == 4) {
  echo "You can enroll at most 4 courses as undergraduate";
}
else if ($degree == "graduate" and $row_cnt2 == 3) {
  echo "You can enroll at most 3 courses as graduate";
}
else if ($level == "graduate" and $degree == "undergraduate") {
  echo "You can not enroll a graduate class as an undergraduate";
}
else if ((int)$Quota == (int)$EnrolledSeats) {
  echo "No available seats for this course";
}
else {
  while($row = mysqli_fetch_array($result))
  {
    if ($row["Day"] == $day && $row["Time"] == $time) {
      echo "Time conflict with currently enrolled class: " . $row["CName"];
      exit;
    }
  }

  $sql = "INSERT INTO Student_Course (SID, CID)
          VALUES ('$SID', '$CID')";

  if ($conn->query($sql) === TRUE)
  {
    echo "Course Successfully Enrolled! ";
  }
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $newEnrolledSeats = (int)$EnrolledSeats + 1;

  $sql = "UPDATE course SET EnrolledSeats = '$newEnrolledSeats' WHERE CID = '$CID'";

  if ($conn->query($sql) === TRUE)
  {
    echo "Course EnrolledSeats Successfully Updated! ";
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