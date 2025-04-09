<?php
    require_once("../database.php");
    require_once("../mainFunctions.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/google-auth/api.php');
    verifyLogin("admin");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
  
  $query = $pdo->prepare("SELECT * FROM surroundingSlides WHERE surround_active = -1");
  $query->execute();
  $preShow = $query->fetchAll(PDO::FETCH_ASSOC);

  $query = $pdo->prepare("SELECT * FROM surroundingSlides WHERE surround_active = 1");
  $query->execute();
  $postShow = $query->fetchAll(PDO::FETCH_ASSOC);


  $query = $pdo->prepare("SELECT * FROM shows");
  $query->execute();
  $shows = $query->fetchAll(PDO::FETCH_ASSOC);

  $students = array();

  if (isset($_GET['id'])) {
    $show_id = $_GET['id'];
    $query = $pdo->prepare("SELECT * FROM students WHERE stud_which_show = ?");
    $query->execute(array($show_id));
    $students = $query->fetchAll(PDO::FETCH_ASSOC);
  }


  foreach ($students as $idx => &$s) {
    $studId = $s['stud_id'];
    $s['photos'] = array();
    $studPics = &$s['photos'];
    for ($x = 9; $x <= 13; $x++) {
        $imgUrl = "../studPics/" . $x . "_" . $studId . ".jpg";
        if (file_exists($imgUrl)) {
            $studPics[] = $imgUrl;
        }
    }
  }

?>
<div id="preShowContainer" style = "color: black; "></div>
<div id="studentShowContainer"></div>
<div id="postShowContainer"  style = "color: black; "></div>

<?php if (!empty($students)): ?>
  <div id="slideshowContainer">
    <?php include("../student/slideshow.php"); ?>
  </div>
<?php endif; ?>

<script>
  var students = <?php echo json_encode($students); ?>;
  var preShow = <?php echo json_encode($preShow); ?>;
  var postShow = <?php echo json_encode($postShow); ?>;
  var preShowContainer = document.getElementById('preShowContainer');
  var studentShowContainer = document.getElementById('studentShowContainer');
  var postShowContainer = document.getElementById('postShowContainer');
  var slideshowContainer = document.getElementById('slideshowContainer');
  var i = 0;

  function updateSlide() {
    if (i < preShow.length) {
      preShowContainer.innerHTML = preShow[i].surround_html;
      studentShowContainer.innerHTML = "";
      postShowContainer.innerHTML = "";
      slideshowContainer.style.display = 'none';
    } else if (i < preShow.length + students.length) {
      preShowContainer.innerHTML = "";
      studentShowContainer.innerHTML = studentSlideshow(students[i - preShow.length]);
      postShowContainer.innerHTML = "";
      slideshowContainer.style.display = 'block';
    } else {
      preShowContainer.innerHTML = "";
      studentShowContainer.innerHTML = "";
      postShowContainer.innerHTML = postShow[i - preShow.length - students.length].surround_html;
      slideshowContainer.style.display = 'none';
    }
  }

  function studentSlideshow(student) {
  
    var studId = student['stud_id'];
    var images = student['photos'];

    for  (let i = 0; i <= 4; i++) {
      document.getElementById('show_pic'+i).src = images[i];
    }
  
     var studCSS = student['stud_css'];

      document.getElementById("show_fname").innerHTML = student['stud_fname'] + " " + student['stud_lname'];
      var awardsHtml = "";
      var memMomentsHtml = "";
      var scholarshipsHtml = "";
      var futurePlansHtml = "";

      var awards = student['stud_awards'] !== "" ? JSON.parse(student['stud_awards']) : "";document.getElementById("awards_font").innerHTML = awards !== "" ? "Awards" : "";
      var memMoments = student['stud_mem_moment'] !== "" ? student['stud_mem_moment'] : "";document.getElementById("memMoment_font").innerHTML = memMoments !== "" ? "Memorable Moments" : "";
      var scholarships = student['stud_scholarships'] !== "" ? JSON.parse(student['stud_scholarships']) : "";document.getElementById("scholarship_font").innerHTML = scholarships !== "" ? "Scholarships" : "";

      var futurePlans = [];
      if (student['stud_future_plans'] != "") {
        document.getElementById("futurePlans_font").innerHTML = "Future plans"; 
        var s_plans = JSON.parse(student['stud_future_plans']);
        var s_plans_school = s_plans["f_plans_school"];
        var s_plans_course = s_plans["f_plans_course"];
        var s_plans_extra = s_plans["f_plans_extra"];

        futurePlans.push(s_plans_school, s_plans_course, s_plans_extra);
      }
      else{
        document.getElementById("futurePlans_font").innerHTML = ""; 
      }
        for (var x = 0; x < awards.length; x++) {
          awardsHtml += '<li style="' + studCSS + '">' + awards[x] + '</li>';
        }
        memMomentsHtml += memMoments;
        for (var x = 0; x < scholarships.length; x++) {
          scholarshipsHtml += "<li>" + scholarships[x] + "</li>";
        }
        for (var x = 0; x < futurePlans.length; x++) {
          futurePlansHtml += "<li>" + futurePlans[x] + "</li>";
        }

      document.getElementById("show_awards").innerHTML = awardsHtml;
      document.getElementById("show_mem_moments").innerHTML = memMomentsHtml;
      document.getElementById("show_future_plans").innerHTML = futurePlansHtml;
      document.getElementById("show_scholarships").innerHTML = scholarshipsHtml;

  }
  
  updateSlide();

  document.addEventListener("keydown", function (event) {
    if (event.keyCode === 37) { // left arrow key
      i--;
      if (i < 0) {
        i = preShow.length + students.length + postShow.length - 1;
      }
    } else if (event.keyCode === 39) { // right arrow key
      i++;
      if (i >= preShow.length + students.length + postShow.length) {
        i = 0;
      }
    }
    updateSlide();
  });
</script>

</body>
</html>



