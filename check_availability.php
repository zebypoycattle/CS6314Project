<?php
$username = $_POST['username'];
if( $username === '') {
  header("location: home.html");
  exit();
}


  $user = 'root';
  $password = 'root';
  $db = 'course_registration';
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

  $sql = "SELECT * FROM user WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);
  mysqli_close();
  $user_count = mysqli_num_rows($result);

  if($user_count>0) {
      echo "Username not available, select a new username.";
  }
  else{
      echo "Username is available.";
  }
?>
