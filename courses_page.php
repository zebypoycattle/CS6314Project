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


$name= $_GET['name'];
$section = $_GET['section'];
$level = $_GET['level'];
$location = $_GET['location'];
$page = $_GET['page'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/home.js"></script>
<script type="text/javascript">

  function add_to_favorites(CID)
  {
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
    var http = "add_to_favorites.php?CID="+CID;
    xmlhttp.open("GET",http,true);
    xmlhttp.send();
  }
  function add_to_cart(CID)
  {
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
    var http = "add_to_cart.php?CID="+CID;
    xmlhttp.open("GET",http,true);
    xmlhttp.send();
  }
  function delete_course(CID)
  {
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
    var http = "delete_course.php?CID="+CID;
    xmlhttp.open("GET",http,true);
    xmlhttp.send();
    location.reload();
  }
</script>

  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/navbar.css">
  <title>Courses</title>
</head>

<body>
    <div class="topnav" id="top">
        <a class="active" href="home.php">Home</a>
        <a href="history.php">History</a>
        <a href="courses_page.php#top">Courses</a>
        <a href="favorites.php#top">Favorites</a>
        <a href="cart.php#top">Enroll</a>
        <div class="topnav-right">
          <a href="logout.php">Logout</a>
        </div>
    </div>
  </div>

  <br><br>
  <div class="form" id="searchCourse">
  <h1> Guided Search </h1>

  <form action="courses_page.php#class_results" id="addForm" method="GET"  enctype='multipart/form-data'>

    <div class="field-wrap">
      <label for="class_name">Class Name </label>
      <input type = "text" id = "name_select" name = "name" value = "<?php echo $name;?>"/>
    </div>
    <div class="field-wrap">
      <label for="class_section">Class Number </label>
      <input type = "text" id = "section_select" name = "section" value = "<?php echo $section;?>"/>
    </div>

    <div class="field-wrap">
      <label for="class_level">Class Level </label>
      <select class="formDropDown" id = "level_select" name = "level">
        <option value="any" style="display:none"></option>
        <option value="any" <?php if($level =='any'){echo "selected ";}?> >Any Level</option>
        <option value="undergraduate" <?php if($level == 'undergraduate'){echo "selected ";}?> >Undergraduate</option>
        <option value="graduate" <?php if($level== 'graduate'){echo "selected ";}?> >Graduate</option>
      </select>
    </div>

    <div class="field-wrap">
      <label  for="class_location">Class Location </label>
      <select class="formDropDown" id = "location_select" name = "location">
        <option value="any" style="display:none"></option>
        <option value="any" <?php if($location =='any'){echo "selected ";}?> >Any Location </option>
        <option value="oncampus" <?php if($location =='oncampus'){echo "selected ";}?> >On Campus</option>
        <option value="online" <?php if($location == 'online'){echo "selected ";}?> >Online</option>
      </select>
    </div>

    <button id="searchClassButton" type="submit" class="button button-block"/>Search</button>

  </form>


</div>


  <br>

  <div id = "class_results">
    <?php
      if(isset($_GET['location']))
      {
        $name = $_GET['name'];
        $section = $_GET['section'];
        $level = $_GET['level'];
        $location = $_GET['location'];
        $page = $_GET['page'];
        if($page =='')
        {
          $page = 1;
        }

        $user = 'root';
        $password = 'root';
        $db = 'course_registration';
        $host = 'localhost';
        $port = 3306;
        $conn = mysqli_connect(
           $host,
           $user,
           $password,
           $db,
           $port
        );
        if (!$conn){
        	echo "Connection failed!";
        	exit;
        }

        //Get number of possible records
        $sql = "SELECT * FROM course c
                INNER JOIN course_professor cp ON c.CID = cp.CID
                INNER JOIN professor p ON p.PID = cp.PID
                INNER JOIN term t ON t.Semester = c.Semester AND t.Year = c.Year
                INNER JOIN department d ON c.DID = d.DID
                LEFT JOIN textbook tb ON c.CID = tb.CID
                WHERE ";

        if($name != "")
        {
          $sql .= "Cname like '%$name%' AND ";
        }
        else
        {
          $sql .= "1 AND ";
        }
        if($section != "")
        {
          $sql .= "CNumber like '%$section%' AND ";
        }
        else
        {
          $sql .= "1 AND ";
        }
        if($level != "any")
        {
          $sql .= "level = '$level' AND ";
        }
        else
        {
          $sql .= "1 AND ";
        }
        if($location == "any")
        {
          $sql .= "1";
        }
        else if($location == 'online')
        {
          $sql .= "Location = '$location'";
        }
        else
        {
          $sql .= "Location != 'online'";
        }
        $sql .= " AND t.currentTermToRegister = 1";
        $sql .= " AND c.IsDeleted = 0";
        $sql .= " order by CNumber asc, Section asc";

        $result = mysqli_query($conn, $sql);

        //Start Paging

        $rowsPerPage = 5;
        if($page=="" || $page =='1')
        {
          $pageStart = 0;
        }
        else {
          $pageStart = ($page*$rowsPerPage) - $rowsPerPage;
        }

        $numRows = mysqli_num_rows($result);
        $numPages = ceil($numRows/$rowsPerPage);

        //Get new page
        $sql .= " limit $pageStart, $rowsPerPage";
        $result = mysqli_query($conn, $sql);

        if($accountType == 'student')
        {
          echo "<table class='table table-striped'><tr><td>Department</td><td>Course Number</td><td>Section Number</td><td>Class Name</td><td>Professor</td><td>Schedule</td><td>Location</td><td>Textbook</td><td>Fill</td><td>Add To Favorites</td><td>Add To Cart</td></tr>";
        }
        else
        {
          echo "<table class='table table-striped'><tr><td>Department</td><td>Course Number</td><td>Section Number</td><td>Class Name</td><td>Professor</td><td>Schedule</td><td>Location</td><td>Textbook</td><td>Fill</td><td>Edit</td><td>Delete</td></tr>";
        }
        while($row = mysqli_fetch_array($result))
        {
          $CID = $row["CID"];
          $Src = $row["Src"];
          echo "<tr><td>". $row['DName']."</td><td>". $row['CNumber']. "</td><td>" . $row['Section'] . "</td><td>" . $row['CName'] . "</td><td>" . $row['FName'] . " " . $row['LName']. "</td>";
          echo "<td>" . $row['Day'] . " " . $row['Time']. "</td><td>" . $row['Location']. "</td>";

          if($row['Src'] == 'None' || $row['Src']== '')
          {
            echo "<td>No Textbook Uploaded</td>";
          }
          else
          {
            echo "<td><a href = 'show_textbook_image.php?CID=$CID&Src=$Src&isCourseSearch=1'><img style = 'width: 60px; height: 75px;' src= 'images/$Src'></a></td>";
          }

          if($row['Quota'] == $row['EnrolledSeats'])
          {
           echo "<td>CLOSED</td>";
          }
          else
          {
           echo "<td>". $row['EnrolledSeats']. "/" . $row['Quota']. "</td>";
          }
          if($accountType == 'student')
          {
           echo "<td> <button onclick='add_to_favorites($CID)'>Add To Favorites</button> </td>";
           echo "<td> <button onclick='add_to_cart($CID)'>Add To Cart</button> </td></tr>";

          }
          else
          {
           echo "<td> <form action='edit_course.php?CID=$CID' method='post'><button id='editClassButton' type='submit' class='button button-block'/>Edit</button></form></td>";
           echo "<td> <button onclick='delete_course($CID)' class='button button-block' >Delete</button></td>";
           echo "</tr>";

          }
        }
        echo "</table>";


        if($numRows != 0)
        {
          //Page links
          echo "<div id = 'divPage' style = 'text-align: center;'>Page";
          $name = preg_replace("/[\s_]/", "%20", $name);
          for($n = 1; $n<=$numPages; $n++)
          {
            if($page == $n || ($page =='' && $n==1))
            {
            echo "<a style= 'color:red;' href = 'courses_page.php?name=$name&section=$section&level=$level&location=$location&page=$n#class_results'> $n </a>";
            }
            else {
              echo "<a href = 'courses_page.php?name=$name&section=$section&level=$level&location=$location&page=$n#class_results'> $n </a>";
            }
          }
          echo "</div>";
        }
          echo '<script type="text/javascript">';
          echo "$('#searchCourse').find('input, select, textarea').prev('label').addClass('active')";
          echo '</script>';

      }



    ?>

  </div>


</body>
</html>
