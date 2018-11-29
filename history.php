<!DOCTYPE html>
<html lang="en">
<head>
  <title>Course History</title>
  <meta charset="utf-8">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/navbar.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
  <div>
    <br><br>
    <h1>Previous Coursework</h1>
  <?php
  session_start();
  if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == '')) {
    header("location: root.html");
    exit();
  }
  else {
    $username = $_SESSION['username'];
    $accountType = $_SESSION['account'];  
  }
  $username = $_SESSION['username'];  
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

  
  if($accountType == 'student') {
    $sql = "SELECT c.*, d.DName 
    FROM user_student AS s 
    INNER JOIN student_course AS sc ON s.SID = sc.SID 
    INNER JOIN course AS c ON sc.CID = c.CID 
    INNER JOIN department AS d ON c.DID = D.DID
    INNER JOIN term AS t ON c.Year = t.Year AND c.Semester = t.Semester 
    WHERE s.Username = '$username' AND t.currentTermToRegister = 0 
    ORDER BY c.CID ASC";
  }
  else {
    $sql = "SELECT c.*, d.DName 
    FROM course AS c
    INNER JOIN department AS d ON c.DID = D.DID
    INNER JOIN term AS t ON c.Year = t.Year AND c.Semester = t.Semester 
    WHERE t.currentTermToRegister = 0 
    ORDER BY c.CID ASC";
  }


  $result = mysqli_query($conn, $sql);

  echo "<table class='table table-striped'><tr><td>Department</td><td>Course Number</td><td>Section</td><td>Course Name</td><td>Semester</td><td>Year</td><td>Day</td><td>Time</td><td>Location</td><td>Level</td></tr>";
  
  while($row = mysqli_fetch_array($result)) {
    echo "<tr><td>".$row["DName"]."</td><td>".$row["CNumber"]."</td><td>" .$row["Section"]. "</td><td>". $row["CName"]."</td><td>".$row["Semester"]."</td><td>".$row["Year"]."</td><td>".$row["Day"]."</td><td>".$row["Time"]."</td><td>".$row["Location"]."</td><td>".$row["Level"]."</td></tr>";
  }
  echo "</table>";
  
  mysqli_close();

  ?>
</div>
</body>
</html>
