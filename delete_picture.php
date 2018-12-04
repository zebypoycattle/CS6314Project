<?php
session_start();


if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == ''))
{
  header("location: root.html");
  exit();
}
else
{
  $username = $_SESSION['username'];
  $accountType = $_SESSION['account'];
  $SID = $_SESSION['SID'];
}
if($accountType!= 'admin')
{
  header("location: root.html");
  exit();
}

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

$CID = $_GET['CID'];
$Src = $_GET['Src'];

$filename = "images" . "/" . $Src;

if (file_exists($filename))
{
    unlink($filename);
}

$sql = "UPDATE textbook
        SET Src = 'None'
        WHERE CID = $CID";

if ($conn->query($sql) === TRUE)
{
  $message.= "Textbook Picture Deleted Successfully\\n";
}
else
{
  $message.= "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close();
echo "<SCRIPT type='text/javascript'>
    alert('$message');
    window.location.replace('courses_page.php?name=&section=&level=any&location=any#class_results');
</SCRIPT>";




?>
