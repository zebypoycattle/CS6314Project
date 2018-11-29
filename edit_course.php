<?php
session_start();
$CID = $_GET["CID"];


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

$sql = "SELECT * FROM course WHERE CID = $CID";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
  $dept = $row["DID"];
  $courseNumber = $row["CNumber"];
  $sectionNumber = $row["Section"];
  $className = $row["CName"];
  $term = $row["Semester"];
  $year = $row["Year"];
  $days = $row["Day"];
  if($days == "M/W") {
    $days = "M";
  }
  else {
    $days = "T";
  }
  $time = $row["Time"];

  $location = $row["Location"];
  $seats = $row["Quota"];
  $level = $row["Level"];
}

//Get PID
$sql = "SELECT * FROM course_professor WHERE CID = $CID";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
  $PID = $row["PID"];
}

//Get professor info
$sql = "SELECT * FROM professor WHERE PID = $PID";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
  $professorFirstName = $row["FName"];
  $professorLastName = $row["LName"];
}



?>


<!DOCTYPE html>
<html lang="en" >

  <head>
    <meta charset="UTF-8">
    <title>Edit Class</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/home.js"></script>
    <script type="text/javascript">
    function updateClass ()
    {
      var dept = document.getElementById("department").value;
      var className = document.getElementById("className").value;
      var courseNumber = document.getElementById("courseNumber").value;
      var sectionNumber = document.getElementById("sectionNumber").value;
      var term = document.getElementById("classTerm").value;
      var year = document.getElementById("yearTerm").value;
      var professorFirstName = document.getElementById("professorFirstName").value;
      var professorLastName = document.getElementById("professorLastName").value;
      var days = document.getElementById("days").value;
      var time = document.getElementById("time").value;
      var level = document.getElementById("classLevel").value;
      var location = document.getElementById("classLocation").value;
      var seats = document.getElementById("classSeats").value;

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
              window.location.replace("courses_page.php");
          }
      };
      var http = "update_course.php?className=" + className +"&department="+dept+"&courseNumber="+courseNumber+"&sectionNumber="+sectionNumber+"&term="+term+"&year="+year+"&professorFirstName="+professorFirstName+"&professorLastName="+professorLastName+"&days="+days+"&time="+time+"&level="+level+"&location="+location+"&seats="+seats+"&CID="+<?php echo $CID?>;
      xmlhttp.open("GET",http,true);
      xmlhttp.send();
      //alert("Course Updated Successsfully");



    }



    </script>

  </head>

    <body>

        <div class="form" id="editCourse">

            <div class="tab-content">


                <h1>Edit Class</h1>

                <form id="editForm" method="POST">

                <div class="field-wrap" id= "deptDiv">
                    <label id="deptText">
                      Department<span class="req">*</span>
                    </label>
                    <select id="department" name="department" class="formDropDown" required>
                      <option style="display:none"></option>
                      <option value="1"<?php if($dept == '1'){echo "selected ";}?>>Computer Science</option>
                      <option value="2"<?php if($dept == '2'){echo "selected ";}?>>Software Engineering</option>
                    </select>
                  </div>


                  <div class="top-row">
                    <div class="field-wrap">
                      <label id="classSectionLabel">
                        Course <span class="req">*</span>
                      </label>
                      <input type="text" id="courseNumber" name="courseNumber" value = "<?php echo $courseNumber; ?>" autocomplete="off"/>
                    </div>
                    <div class="field-wrap">
                      <label id="classSectionNumberLabel">
                        Section Number<span class="req">*</span>
                      </label>
                      <input type="text" id="sectionNumber" name="sectionNumber" value = "<?php echo $sectionNumber; ?>" autocomplete="off"/>
                    </div>
                  </div>

                  <div class="field-wrap">
                    <label id="courseNameLabel">
                      Course Name<span class="req">*</span>
                    </label>
                    <input type="text" id="className" name="className" value = "<?php echo $className; ?>" autocomplete="off"/>
                  </div>

                  <div class="top-row">
                      
                    <div class="field-wrap">
                      <label id="termText">
                        Term<span class="req">*</span>
                      </label>
                      <select class="formDropDown" id="classTerm" name="term" required>
                        <option style="display:none"></option>
                        <option value="Spring" <?php if($term == 'Spring'){echo "selected ";}?> >Spring</option>
                        <option value="Summer" <?php if($term == 'Summer'){echo "selected ";}?> >Summer</option>
                        <option value="Fall" <?php if($term == 'Fall'){echo "selected ";}?> >Fall</option>
                      </select>
                    </div>

                       <div class="field-wrap">
                        <label id="yearText">
                          Year<span class="req">*</span>
                        </label>
                        <select id="yearTerm" class="formDropDown" name="year" required>
                          <option style="display:none"></option>
                          <option value="2019" <?php if($year == '2019'){echo "selected ";}?> >2019</option>
                          <option value="2020" <?php if($year == '2020'){echo "selected ";}?> >2020</option>
                        </select>
                      </div>
                  </div>

                  <div class="top-row">
                    <div class="field-wrap" id= "professorfirstNameDiv">
                      <label>
                        Professor First Name<span class="req">*</span>
                      </label>
                      <input type="text" id = "professorFirstName" name="professorfirstName" value = "<?php echo $professorFirstName; ?>" autocomplete="off" />
                    </div>

                    <div class="field-wrap" id= "professorLastNameDiv">
                      <label>
                        Professor Last Name<span class="req">*</span>
                      </label>
                      <input type="text" id = "professorLastName" name="professorLastName" value = "<?php echo $professorLastName; ?>" autocomplete="off"/>
                    </div>
                  </div>

                  <div class="top-row">
                    <div class="field-wrap">
                      <label id="daysText">
                        Days<span class="req">*</span>
                      </label>
                      <select class="formDropDown" id="days" name="days" required>
                        <option style="display:none"></option>
                        <option value="M" <?php if($days == 'M'){echo "selected ";}?> >M/W</option>
                        <option value="T" <?php if($days == 'T'){echo "selected ";}?> >T/Th</option>
                      </select>
                    </div>

                    <div class="field-wrap">
                      <label id="timeText">
                        Time<span class="req">*</span>
                      </label>
                      <select class="formDropDown" id="time" name="time" required>
                        <option style="display:none"></option>
                        <option value="8:30am-9:45am" <?php if($time == '8:30am-9:45am'){echo "selected ";}?> >8:30am-9:45am</option>
                        <option value="10:00am-11:15am" <?php if($time == '10:00am-11:15am'){echo "selected ";}?> >10:00am-11:15am</option>
                        <option value="11:30am-12:45pm" <?php if($time == '11:30am-12:45pm'){echo "selected ";}?> >11:30am-12:45pm</option>
                        <option value="1:00pm-2:15pm" <?php if($time == '1:00pm-2:15pm'){echo "selected ";}?> >1:00pm-2:15pm</option>
                        <option value="2:30pm-3:45pm" <?php if($time == '2:30pm-3:45pm'){echo "selected ";}?> >2:30pm-3:45pm</option>
                        <option value="4:00pm-5:15pm" <?php if($time == '4:00pm-5:15pm'){echo "selected ";}?> >4:00pm-5:15pm</option>
                      </select>
                    </div>
                  </div>

                  <div class="field-wrap">
                    <label id="locationLabel">
                      Class Location<span class="req">*</span>
                    </label>
                    <input type="text" id="classLocation" name="classLocation" value = "<?php echo $location; ?>" autocomplete="off"/>
                  </div>

                  <div class="field-wrap">
                    <label id="levelText">
                      Level<span class="req">*</span>
                    </label>
                    <select class="formDropDown" id="classLevel" name="level" required>
                      <option style="display:none"></option>
                      <option value="Undergraduate" <?php if($level == 'Undergraduate'){echo "selected ";}?> >Undergraduate</option>
                      <option value="Graduate" <?php if($level == 'Graduate'){echo "selected ";}?> >Graduate</option>
                    </select>
                  </div>

                  <div class="field-wrap">
                    <label id="seatsLabel">
                      Total Seats<span class="req">*</span>
                    </label>
                    <input type="text" id="classSeats" name="classSeats" value = "<?php echo $seats; ?>" autocomplete="off"/>
                  </div>

                    <button id = "updateClassButton" class="button button-block" value="Update Class" onclick = "updateClass()"/>Update Class</button>

                </form>

              </div>

          </div><!-- tab-content -->


      </body>

</html>
