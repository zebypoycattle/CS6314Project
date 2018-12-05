<?php
session_start();

$dept = $_POST["department"];
$className = $_POST["className"];
$courseNumber = $_POST["courseNumber"];
$sectionNumber = $_POST["sectionNumber"];
$term = $_POST["term"];
$year = $_POST["year"];
$professorFirstName = $_POST["professorFirstName"];
$professorLastName = $_POST["professorLastName"];
$day = $_POST["days"];

$time = $_POST["time"];
$level = $_POST["level"];
$location = $_POST["location"];
$seats = $_POST["seats"];

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
  echo "<SCRIPT type='text/javascript'>
      alert('Connection Failed');
      window.location.replace('create.html');
  </SCRIPT>";
	exit();
}

//Check if professor teaches a section at this schedule already
$sql = "SELECT *
        FROM course c
        INNER JOIN course_professor cp ON cp.CID = c.CID
        INNER JOIN professor p ON p.PID = cp.PID
        WHERE p.FName = '$professorFirstName'
        AND p.LName = '$professorLastName'
        AND c.Semester = '$term'
        AND c.Year = $year
        AND c.Day = '$day'
        AND c.Time = '$time'
        AND c.isDeleted = 0";

$result = mysqli_query($conn, $sql);
$rowcount = $result->num_rows;

if($rowcount != 0)
{
  echo "<SCRIPT type='text/javascript'>
      alert('Error: This professor is already teaching a course at this day and time');
      window.location.replace('create.html');
  </SCRIPT>";
  exit();
}

//Check if section exists already
$sql = "SELECT *
        FROM course c
        WHERE c.DID = '$dept'
        AND c.CNumber = '$courseNumber'
        AND c.Section = '$sectionNumber'
        AND c.Semester = '$term'
        AND c.Year = '$year'
        AND c.isDeleted = 0";

$result = mysqli_query($conn, $sql);
$rowcount = $result->num_rows;

if($rowcount != 0)
{
  echo "<SCRIPT type='text/javascript'>
      alert('Error: This course and section already exist');
      window.location.replace('create.html');
  </SCRIPT>";
  exit();
}

//Check if we can just switch isDeleted flag off
$sql = "SELECT *
        FROM course c
        WHERE c.DID = '$dept'
        AND c.CNumber = '$courseNumber'
        AND c.Section = '$sectionNumber'
        AND c.Semester = '$term'
        AND c.Year = '$year'
        AND c.isDeleted = 1";

$result = mysqli_query($conn, $sql);
$rowcount = $result->num_rows;

$updateFlag = 0;
if($rowcount != 0)
{
  $updateFlag = 1;
  while($row = mysqli_fetch_array($result))
  {
    $CID = $row["CID"];
  }
}

//Check if professor exists already
$sql = "SELECT * FROM professor WHERE FName = '$professorFirstName' AND LName = '$professorLastName'";
$result = mysqli_query($conn, $sql);
$rowcount = $result->num_rows;
//Insert new professor
if($rowcount == 0)
{
  $sql = "INSERT INTO professor (DID, FName, LName, Email)
          VALUES ('$dept','$professorFirstName', '$professorLastName', '$professorFirstName$professorLastName@utdallas.edu')";
  if ($conn->query($sql) === TRUE)
  {
    $message.= "New Professor Added Successfully\\n";
  }
  else
  {
    $message.= "Error: " . $sql . "<br>" . $conn->error;
  }
}

if($updateFlag == 0)
{
  //Insert into courses
  $sql = "INSERT INTO Course (DID, CNumber, Section, CName, Semester, Year, Day, Time, Location, Quota, Level, isDeleted, EnrolledSeats)
          VALUES ('$dept', '$courseNumber', '$sectionNumber', '$className', '$term', '$year', '$day', '$time', '$location', '$seats', '$level', '0', '0')";
  if ($conn->query($sql) === TRUE)
  {
    $message.= "Course Added Successfully\\n";
  }
  else
  {
    $message.= "Error: " . $sql . "<br>" . $conn->error;
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
    $message.= "Course_Professor Added Successfully\\n";
  }
  else
  {
    $message.= "Error: " . $sql . "<br>" . $conn->error;
  }



  //Insert Picture
  if (empty($_FILES['textbookSrc']['name']))
  {
    $sql = "INSERT INTO textbook (CID, Src)
            VALUES ($CID, 'None')";
    if ($conn->query($sql) === TRUE)
    {
      $message.= "";
    }
    else
    {
      $message.= "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  else
  {
    $tmp_name = $_FILES["textbookSrc"]["tmp_name"];
    $name = $_FILES["textbookSrc"]["name"];

    $sql = "INSERT INTO textbook (CID, Src)
            VALUES ($CID, '$name')";

    if ($conn->query($sql) === TRUE)
    {
      $message.= "Textbook added Successfully\\n";
    }
    else
    {
      $message.= "Error: " . $sql . "<br>" . $conn->error;
    }

    move_uploaded_file($tmp_name, "images" . "/" . $name);

  }
}

else if ($updateFlag == 1)
{
  //Insert into courses
  $sql = "UPDATE course
          SET CName = '$className', Day = '$day', Time = '$time', Location = '$location', Level = '$level', Quota = $seats, isDeleted = 0
          WHERE CID = $CID";

  if ($conn->query($sql) === TRUE)
  {
    $message.= "Course existed and...\\nCourse was updated successfully\\n";
  }
  else
  {
    $message.= "Error: " . $sql . "<br>" . $conn->error;
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

  //Insert into course_professor
  $sql = "INSERT INTO course_professor (CID, PID)
          VALUES ($CID, $PID)";

  if ($conn->query($sql) === TRUE)
  {
    $message.= "Course professor updated Successfully\\n";
  }
  else
  {
    $message.= "Error: " . $sql . "<br>" . $conn->error;
  }



  //Insert Picture
  if (empty($_FILES['textbookSrc']['name']))
  {
    $sql = "INSERT INTO textbook (CID, Src)
            VALUES ($CID, 'None')";
            
    if ($conn->query($sql) === TRUE)
    {
      $message.= "";
    }
    else
    {
      $message.= "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  else
  {
    $tmp_name = $_FILES["textbookSrc"]["tmp_name"];
    $name = $_FILES["textbookSrc"]["name"];

    $sql = "INSERT INTO textbook (CID, Src)
            VALUES ($CID, '$name')";

    if ($conn->query($sql) === TRUE)
    {
      $message.= "Textbook Updated Successfully\\n";
    }
    else
    {
      $message.= "Error: " . $sql . "<br>" . $conn->error;
    }

    move_uploaded_file($tmp_name, "images" . "/" . $name);

  }
}
mysqli_close();
echo "<SCRIPT type='text/javascript'>
    alert('$message');
    window.location.replace('create.html');
</SCRIPT>";
?>
