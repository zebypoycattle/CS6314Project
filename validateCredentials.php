<?php
    $username = $_GET['username'];
    $success;

  $user = 'root';
  $password = 'root';
  $db = 'hw3';
  $host = 'localhost';
  $port = 3306;

  $conn = mysqli_init();
  $conn = mysqli_connect(
     $host,
     $user,
     $password,
     $db,
     $port
  );

  if (!$conn) {
    echo "Connection failed!";
    exit;
  }



  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);
  mysqli_close();

  if(mysqli_num_rows($result) != 1) {
    $success = false;
  }
  else{
    $success = true;
  }

  echo json_encode($success);


  ?>