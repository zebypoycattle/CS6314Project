<?php
session_start();
if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == '')) {
  header("location: root.html");
  exit();
}
?>
<html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
    	<title>Home Page</title>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    	<link rel="stylesheet" href="css/style.css">
    	<link rel="stylesheet" href="css/navbar.css">
	</head>
	<body>
		<div class="topnav">
  			<a class="active" href="home.html">Home</a>
        <a href="history.php">History</a>
  			<a href="courses_page.php">Courses</a>
  			<a href="favorites.php">Favorites</a>
  			<a href="cart.php">Enroll</a>
  			<div class="topnav-right">
    			<a href="logout.php">Logout</a>
  			</div>
		</div>
      <h1> Welcome to Course Registration </h1>
    <div>
    </div>
	</body>
</html>
