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
    	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    	<link rel="stylesheet" href="css/style.css">
    	<link rel="stylesheet" href="css/navbar.css">
      <script type="text/javascript">
        function showData () {

          if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
          }
          else {
                // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function()
          {
              if (this.readyState == 4 && this.status == 200){
                  document.getElementById("cart_results").innerHTML = this.responseText;
              }
          };

          var http = "enrolledClasses.php";

          xmlhttp.open("GET",http,true);
          xmlhttp.send();
        }
        function unenroll(CID) {
          if (window.XMLHttpRequest)
          {
                // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          }
          else
          {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function()
          {
              if (this.readyState == 4 && this.status == 200)
              {
                var test = this.responseText;
                alert(test);
              }
          };
          var http = "unenroll.php?CID="+CID;
          xmlhttp.open("GET",http,true);
          xmlhttp.send();
          showData();
        }
    </script>
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


        $sql = "SELECT FName FROM user WHERE Username = '$username'";
        $record = mysqli_fetch_array(mysqli_query($conn, $sql));
        mysqli_close();
        $name = ucfirst($record['FName']);
        echo "<br><br><h1> Welcome to Course Registration, $name!</h1>";
      ?>
      <ul>
        <?php

          if($accountType!= 'student') {
            echo  "<li><a href='create_course.html'>Click here to add new courses or register new accounts.</a></li>";
            echo  "<li>Click on the History tab to see all previous coursework.</li>";
            echo  "<li>Click on the Courses tab to search, edit, and delete courses.</li>";
            echo  "<li>Click on the Favorites tab to see courses currently favorited by students.</li>";
            echo  "<li>Click on the Enroll tab to see the current enrollment of all courses.</li>";
          }
          else {
            echo  "<li>Click on the History tab to see your previous coursework.</li>";
            echo  "<li>Click on the Courses tab to search for courses.</li>";
            echo  "<li>Click on the Favorites tab to see your favorited courses.</li>";
            echo  "<li>Click on the Enroll tab to arrange your cart and enroll in your courses.</li>";
          }


        ?>
  
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

            

             $sql = "SELECT c.*, d.DName 
             FROM user_student AS s 
             INNER JOIN student_course AS sc ON s.SID = sc.SID 
             INNER JOIN course AS c ON sc.CID = c.CID 
             INNER JOIN term AS t ON c.Year = t.Year AND c.Semester = t.Semester 
             INNER JOIN department AS d on C.DID = D.DID
             WHERE s.SID = '$SID' AND t.currentTermToRegister = 1 
             ORDER BY c.CID ASC";


            $result = mysqli_query($conn, $sql);


            
            if(mysqli_num_rows($result) > 0) {
              echo "<br><br>";
              echo "<h1>Upcoming Semester Enrollment</h1>";
              echo "<table class='table table-striped'><tr><td>Department</td><td>Course Number</td><td>Section</td><td>Course Name</td><td>Semester</td><td>Year</td><td>Day</td><td>Time</td><td>Location</td><td>Level</td><td>Un-Enroll From Class</td></tr>";
              
              while($row = mysqli_fetch_array($result)) {
                $CID = $row["CID"];

                echo "<tr><td>".$row["DName"]."</td><td>".$row["CNumber"]."</td><td>" .$row["Section"]. "</td><td>". $row["CName"]."</td><td>".$row["Semester"]."</td><td>".$row["Year"]."</td><td>".$row["Day"]."</td><td>".$row["Time"]."</td><td>".$row["Location"]."</td><td>".$row["Level"]."</td>";
                echo "<td> <button onclick='unenroll($CID)'>Un-Enroll</button> </td></tr>";
              }
              echo "</table>";
            }
            
            mysqli_close();
          }
      ?>
    </div>
	</body>
</html>
