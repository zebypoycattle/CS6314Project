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

$CID = $_GET['CID'];





?>
