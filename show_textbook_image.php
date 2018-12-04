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

?>


<!DOCTYPE html>
<html lang="en">

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/home.js"></script>
<meta charset="utf-8">
<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/navbar.css">
<title>Textbook</title>
<div class="form">

<?php

$Src = $_GET["Src"];
$CID = $_GET["CID"];
$isCourseSearch = $_GET['isCourseSearch'];

echo "<img src= 'images/$Src' style = 'display: block; margin-left: auto; margin-right: auto; margin-bottom: 25px;'>";

if($accountType == 'admin' && $isCourseSearch == 1)
{
echo "<td> <form action='delete_picture.php?CID=$CID&Src=$Src' method='post'><button id='deletePictureButton' type='submit' class='button button-block'/>Delete Picture</button></form></td>";
}
echo "</div>";

exit();

?>
