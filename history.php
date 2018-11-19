<!DOCTYPE html>
<html lang="en">
<head>
  <title>Course History</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
  <div class="topnav">
      <a class="active" href="home.php">Home</a>
      <a href="history.php">History</a>
      <a href="guided_search.html">Guided Search</a>
      <a href="favorites.php">Favorites</a>
      <a href="cart.php">Enroll</a>
      <div class="topnav-right">
        <a href="logout.php">Logout</a>
      </div>
  </div>
  <div>
    <h1>Previous Coursework</h1>
  <?php
  session_start();
  if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == '')) {
    header("location: root.html");
    exit();
  }
  else {
    $username = $_SESSION['username'];  
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

  

  $sql = "SELECT c.* FROM user_student AS s INNER JOIN student_course AS sc on s.SID = sc.SID INNER JOIN course AS c ON sc.CID = c.CID WHERE s.Username = '$username' ORDER BY c.CID ASC";


  $result = mysqli_query($conn, $sql);

  echo "<table class='table table-striped'><tr><td>Course ID</td><td>Section</td><td>Course Name</td><td>Term</td><td>Schedule</td><td>Location</td><td>Level</td></tr>";
  
  while($row = mysqli_fetch_array($result)) {
    echo "<tr><td>". $row["CID"] ."</td><td>" .$row["Section"]. "</td><td>". $row["CName"]."</td><td>". $row["Term"]."</td><td>" .$row["Schedule"]. "</td><td>". $row["Location"]."</td><td>".$row["Level"]."</td></tr>";
  }
  echo "</table>";
  
  mysqli_close();

  ?>
</div>
</body>
</html>
