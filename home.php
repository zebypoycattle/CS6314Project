<?php
session_start();

 $username = $_SESSION['username'];
 $accountType = $_SESSION['account'];
 $SID = $_SESSION['SID'];
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
  			<a class="active" href="home.php">Home</a>
        <a href="history.php">History</a>
  			<a href="courses_page.php">Courses</a>
  			<a href="favorites.php">Favorites</a>
  			<a href="cart.php">Enroll</a>
  			<div class="topnav-right">
    			<a href="logout.php">Logout</a>
  			</div>
		</div>
      <?php
        echo "<br><br><h1> Welcome to Course Registration, $username!</h1>";
      ?>
      <ul>
        <?php

          if($accountType!= 'student')
          {
            echo  "<li><a href='create_course.html'>Add New Courses or Accounts</a></li>";
          }

        ?>
        <li>Click on the History tab to see your previous coursework.</li>
        <li>Click on the Courses tab to search for courses.</li>
        <li>Click on the Favorites tab to see your favorited courses.</li>
        <li>Click on the Enroll tab to arrange your cart and enroll in your courses.</li>
      </ul>
      <div>
      <?php

         if($accountType == 'student') {
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

            

            $sql = "SELECT c.* FROM user_student AS s INNER JOIN student_course AS sc on s.SID = sc.SID INNER JOIN course AS c ON sc.CID = c.CID INNER JOIN term AS t ON c.term = t.term WHERE s.Username = '$username' AND t.currentTermToRegister = 1 ORDER BY c.CID ASC";


            $result = mysqli_query($conn, $sql);

            
            if(mysqli_num_rows($result) > 0) {
              echo "<br><br>";
              echo "<h1>Upcoming Semester Enrollment</h1>";
              echo "<table class='table table-striped'><tr><td>Course ID</td><td>Section</td><td>Course Name</td><td>Term</td><td>Schedule</td><td>Location</td><td>Level</td></tr>";
              while($row = mysqli_fetch_array($result)) {
                echo "<tr><td>". $row["CID"] ."</td><td>" .$row["Section"]. "</td><td>". $row["CName"]."</td><td>". $row["Term"]."</td><td>" .$row["Schedule"]. "</td><td>". $row["Location"]."</td><td>".$row["Level"]."</td></tr>";
              }
              echo "</table>";
            }
            
            mysqli_close();
            }
      ?>
    </div>
	</body>
</html>
