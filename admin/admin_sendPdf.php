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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <style>
        @font-face {
            font-family: font_montserrat_light;
            src: url(../images/montserrat_light.ttf);
        }
        body {
            overflow: hidden;
            color: white;
            font-family: font_montserrat_light;
        }
        .red {
            position: absolute;
            background-color: rgb(136, 8, 8);
            width: 20%;
            height: 100%;
            top: 10px;
            z-index: 1;
        }
        .blue {
            position: absolute;
            background-color: #000058;
            height: 90%;
            width: 95%;
            top: 50px;
            left: 3%;
            z-index: 2;
        }
        .content {
            position: absolute;
            top: 130px;
            z-index: 3;
        }
        .logo {
            position: absolute;
            top: 0;
            left: 150px;
            z-index: 3;
            opacity: 0.15;
            filter: sepia(100%) hue-rotate(190deg) saturate(50%);
            transform: rotate(20deg);
            width: 1500px;
            height: 800px;
        }
    </style>
</head>
<body>
<?php
  $query = $pdo->prepare("SELECT * FROM `students` WHERE `stud_id` = :id");
  $query ->bindparam(":id", $id); 
  $query->execute();
  $student = $query->fetch(PDO::FETCH_ASSOC);
  // include("../admin/slideshowPDF.php");
?>

<div class="red"></div>
<div class="blue"></div>

<img class="logo" src="../images/wcss_logo.png" alt="WCSS logo">

<div class="content">
    <div style="display: flex;">

        <div style="margin-left: 80px;">
            <div style="position: fixed; top: 50px; right: 40px;">
                <h1>WEST CARLETON</h1>
            </div>
        
            <div style="position: fixed; top: 100px; right: 40px; font-weight: bold;">
                <h1 id="show_fname"><?php echo $student['stud_fname']; ?></h1>
                <h1 id="show_lname"><?php echo $student['stud_lname']; ?></h1>
            </div>
            <div style="position: fixed; top: 130px; left: 500px">
                <h1 id="awards_font">Awards</h1>
                <ul id="show_awards">
                <?php
                if (is_array($student['stud_awards'])) {
                    foreach ($student['stud_awards'] as $award) {
                        echo "<li>$award</li>";
                    }
                }
                echo $student['stud_awards'];
                ?>
                </ul>
                <h1 id="futurePlans_font">Future Plans</h1>
                <ul id="show_future_plans">
                <?php
                if (is_array($student['stud_future_plans'])) {
                    $futurePlans = json_decode($student['stud_future_plans'], true);
                    foreach ($futurePlans as $key => $value){
                      echo "<li><strong>$key:</strong>$value</li>";
                    }
                }
                echo $student['stud_future_plans'];
                ?>
                </ul>
                <h1 id="scholarship_font">Scholarships</h1>
                <ul id="show_scholarships"><?php echo $student['stud_scholarships']; ?></ul>
                <h1 id="memMoment_font">Memorable Moments</h1>
                <h4 id="show_mem_moments"><?php echo $student['stud_mem_moment']; ?></h4>
            </div>
        </div>
    </div>
</div>

</body>
</html>
