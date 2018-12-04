<?php

session_start();
$CID = $_GET["CID"];
$DID = $_POST["department"];
$CNumber = $_POST["courseNumber"];
$Section = $_POST["sectionNumber"];
$CName = $_POST["className"];
$Semester = $_POST["term"];
$Year = $_POST["year"];
$professorFirstName = $_POST["professorFirstName"];
$professorLastName = $_POST["professorLastName"];
$Day = $_POST["days"];
$Time = $_POST["time"];
$Level = $_POST["level"];
$Location = $_POST["classLocation"];
$Quota = $_POST["classSeats"];

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

$message = "";

if (!$conn){

	$message.= "Connection failed!";
	exit();
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
  $sql = "INSERT INTO professor (DID, FName, LName, Email)
          VALUES ('$DID', '$professorFirstName', '$professorLastName', '$professorFirstName$professorLastName@utdallas.edu')";
  if ($conn->query($sql) === TRUE)
  {
    $message.= "New Professor Added Successfully\\n";
  }
  else
  {
    $message.= "Error: " . $sql . "<br>" . $conn->error;
  }
}

//Update Course
$sql = "UPDATE course
        SET DID = '$DID', CNumber = '$CNumber', Section = '$Section', CName = '$CName', Semester = '$Semester', Year = $Year, Day = '$Day', Time = '$Time', Location = '$Location', Level = '$Level', Quota = $Quota
        WHERE CID = $CID";

if ($conn->query($sql) === TRUE) {
    $message.= "Course Updated Successfully\\n";
} else {
    $message.= "Error updating record: " . $conn->error;
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
  $sql = "UPDATE course_professor
          SET PID = $PID
          WHERE CID = $CID";

  if ($conn->query($sql) === TRUE)
  {
    $message.= "Course Professor Updated Successfully\\n";
  }
  else
  {
    $message.= "Error: " . $sql . "<br>" . $conn->error;
  }

  //Change Picture
  if (empty($_FILES['textbookSrc']['name']))
  {

  }
  else
  {

    $sql = "SELECT Src
            FROM textbook
            WHERE CID = $CID";

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result))
    {
        $Src= $row["Src"];
    }

    $filename = "images" . "/" . $Src;

    if (file_exists($filename))
    {
        unlink($filename);
    }

    $tmp_name = $_FILES["textbookSrc"]["tmp_name"];
    $name = $_FILES["textbookSrc"]["name"];

    $sql = "UPDATE textbook
            SET Src = '$name'
            WHERE CID = $CID";



    if ($conn->query($sql) === TRUE)
    {
      $message.= "Textbook updated Successfully\\n";
    }
    else
    {
      $message.= "Error: " . $sql . "<br>" . $conn->error;
    }

    move_uploaded_file($tmp_name, "images"."/".$name);
  }

  mysqli_close();
  echo "<SCRIPT type='text/javascript'>
      alert('$message');
      window.location.replace('courses_page.php?name=&section=&level=any&location=any#class_results');
  </SCRIPT>";

?>
