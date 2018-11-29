<?php
session_start();

if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == ''))
{
  header("location: root.html");
  exit();
}

$CID = $_GET["CID"];

echo "<img src= 'images/$CID.jpg'>";

exit();

?>
