<!DOCTYPE html>
<html lang="en">

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">


  function showData ()
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
            document.getElementById("class_results").innerHTML = this.responseText;
        }
    };

    var name = document.getElementById("name_select").value;
    var section = document.getElementById("section_select").value;
    var level = document.getElementById("level_select").value;
    var location = document.getElementById("location_select").value;
    var http = "guided_search.php?name=" + name +"&section="+section+"&level="+level+"&location="+location;

    xmlhttp.open("GET",http,true);
    xmlhttp.send();
  }

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
    showData();


  }

</script>

	<meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/class_search.css">
  <link rel="stylesheet" href="css/navbar.css">
	<title>Courses</title>
</head>

<body>

  <div class="topnav">
      <a class="active" href="#home">Home</a>
      <a href="history.php">History</a>
      <a href="courses_page.php">Courses</a>
      <a href="favorites.php">Favorites</a>
      <a href="cart.php">Enroll</a>
      <div class="topnav-right">
        <a href="logout.php">Logout</a>
      </div>
  </div>

  <br><br>
  <h1> Guided Search </h1>

  <?php
    session_start();
    $username = $_SESSION['username'];
    $accountType = $_SESSION['account'];
    $SID = $_SESSION['SID'];

    if($accountType!= 'student')
    {

      echo "<br>";
      echo  "<form action='create_course.html'><input style = 'margin-left: 40%; margin-right: 40%; width: 20%;' id = 'add_course_button' type='submit' value='Add New Class'></form>";
    }

  ?>



  <br>

  <form class="submit" id = "class_search_form" method = "get">

    <label for="class_name">Class Name: </label>
    <input type = "text" id = "name_select"><br>

    <label for="class_section">Class Section: </label>
    <input type = "text" id = "section_select"><br>

    <label for="class_level">Class Level: </label>
    <select id = "level_select">
      <option value="any">Any Level</option>
      <option value="undergraduate">Undergraduate</option>
      <option value="graduate">Graduate</option>
    </select><br>

    <label for="class_location">Class Location: </label>
    <select id = "location_select">
      <option value="any">Any Location</option>
      <option value="on campus">On Campus</option>
      <option value="online">Online</option>
    </select><br>

  </form>

  <input type="button" id = "search_button" value="Search" onclick = "showData()">



  <br>

  <div id = "class_results">
  </div>

  <div id = "add_results">
  </div>

</body>
</html>
