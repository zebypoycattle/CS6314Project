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

	echo "Connection failed!";
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
    $message.= "New Professor Added Successfully\n";
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
    $message.= "Course updated successfully\n";
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
    $message.= "Course_Professor Updated Successfully\n";
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

    $filename = "images" . "/" . $CID . ".jpg";
    if (file_exists($filename))
    {
        unlink($filename);
    }

    $tmp_name = $_FILES["textbookSrc"]["tmp_name"];
    $newImagePath = $CID.".jpg";

    $sql = "UPDATE textbook
            SET Src = '$newImagePath'
            WHERE CID = $CID";

    if ($conn->query($sql) === TRUE)
    {
      echo "Textbook updated Successfully\n";
    }
    else
    {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    move_uploaded_file($tmp_name, "images"."/".$newImagePath);
  }


  echo "<script type='text/javascript'>alert($message);</script>";
  header("Location: courses_page.php#class_results");
  mysqli_close();


?>
