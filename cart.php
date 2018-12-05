<!DOCTYPE html>
<html lang="en">

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/home.js"></script>
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
            document.getElementById("cart_results").innerHTML = this.responseText;
        }
    };

    var name = document.getElementById("name_select").value;
    var section = document.getElementById("section_select").value;
    var level = document.getElementById("level_select").value;
    var location = document.getElementById("location_select").value;
    var http = "cart_search.php?name=" + name +"&section="+section+"&level="+level+"&location="+location;

    xmlhttp.open("GET",http,true);
    xmlhttp.send();
  }

  function enroll(CID)
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

    var http = "enroll.php?CID="+CID;

    xmlhttp.open("GET",http,true);
    xmlhttp.send();

    showData();
  }

  function remove_from_cart(CID)
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

    var http = "remove_from_cart.php?CID="+CID;

    xmlhttp.open("GET",http,true);
    xmlhttp.send();

    showData();
  }

</script>

  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/navbar.css">
  <title>Cart</title>
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

<div class="form">
  <h1> Cart </h1>

  <form class="submit" id = "class_search_form" method = "get">

    <div class="field-wrap">
      <label for="class_name">Class Name </label>
      <input type = "text" id = "name_select">
    </div>
    <div class="field-wrap">
      <label for="class_section">Class Number </label>
      <input type = "text" id = "section_select">
    </div>

    <div class="field-wrap">
      <label for="class_level">Class Level </label>
      <select class="formDropDown" id = "level_select">
        <option value="any" class="hideFirstElement"></option>
        <option value="any">Any Level</option>
        <option value="undergraduate">Undergraduate</option>
        <option value="graduate">Graduate</option>
      </select>
    </div>

    <div class="field-wrap">
      <label  for="class_location">Class Location </label>
      <select class="formDropDown" id = "location_select">
        <option value="any" class="hideFirstElement"></option>
        <option value="any">Any Location</option>
        <option value="on campus">On Campus</option>
        <option value="online">Online</option>
      </select>
    </div>

  </form>

  <input type="button" class="button button-block" id = "search_button" value="Search" onclick = "showData()">
</div>
  <br>

  <div id = "cart_results">
  </div>
  <script>window.onload = showData();</script>
</body>
</html>
