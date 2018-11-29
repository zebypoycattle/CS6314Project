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