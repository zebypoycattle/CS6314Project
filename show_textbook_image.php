<?php
session_start();

if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == ''))
{
  header("location: root.html");
  exit();
}

$Src = $_GET["Src"];

echo "<img src= 'images/$Src'>";

exit();

?>
