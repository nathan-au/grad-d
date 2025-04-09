<style>
    #wrap {
        overflow: hidden;
        width: 100vw;
        height: 100vh;
    }

    #iFrameID {
        width: 1920px;
        height: 1080px;
        border: 0px;
        -ms-zoom: 0.7;
        -moz-transform: scale(0.7);
        -moz-transform-origin: 50% 50%;
        -o-transform: scale(0.7);
        -o-transform-origin: 50% 50%;
        -webkit-transform: scale(0.7);
        -webkit-transform-origin: 50% 50%;
    }
</style>

<?php
    require("stud_functions.php");
    $stud_id = getUserInfo("stud_id");
    $query = $pdo->prepare("SELECT * FROM students WHERE stud_id = :stud_id");
    $query->bindParam(':stud_id', $stud_id);
    $query->execute();
    $student = $query->fetch(PDO::FETCH_ASSOC);
    // echo "<h2>Hi " . $student['stud_fname'] . "</h2>";

    $studId = $student['stud_id'];
    $student['photos'] = array();
    $studPics = &$student['photos'];
    for ($x = 9; $x <= 13; $x++) {
        $imgUrl = "../studPics/" . $x . "_" . $studId . ".jpg";
        if (file_exists($imgUrl)) {
            $studPics[] = $imgUrl;
        }
    }
?>

<div class="wrap">
    <iframe src="slideshow.php" class="iFrameID" title="Iframe Example" id="iFrameID"></iframe>
</div>

<script>
    var iframe = document.getElementById("iFrameID");
    iframe.addEventListener("load", function () {
        var student = <?php echo json_encode($student); ?>;
        var studId = student['stud_id'];
        var images = student['photos'];
        var iframeDocument = iframe.contentWindow.document;

        for (let i = 0; i <= images.length; i++) {
            var img = iframeDocument.createElement('img');
            img.src = images[i];
            img.id = 'show_pic' + i;

            var carouselItem = iframeDocument.createElement('div');
            carouselItem.classList.add('carousel-item');
            if (i === 0) {
                carouselItem.classList.add('active');
            }
            
            carouselItem.appendChild(img);
            iframeDocument.getElementById('carouselInner').appendChild(carouselItem);

        }

        iframeDocument.getElementById("show_fname").innerHTML = student['stud_fname'] + " " + student['stud_lname'];

        var awardsHtml = "";
        var memMomentsHtml = "";
        var scholarshipsHtml = "";
        var futurePlansHtml = "";

        var awards = student['stud_awards'] !== "" ? JSON.parse(student['stud_awards']) : [];
        iframeDocument.getElementById("awards_font").innerHTML = awards.length !== 0 ? "Awards" : "";
        
        var memMoments = student['stud_mem_moment'] !== "" ? student['stud_mem_moment'] : "";
        iframeDocument.getElementById("memMoment_font").innerHTML = memMoments !== "" ? "Memorable Moments" : "";

        var scholarships = student['stud_scholarships'] !== "" ? JSON.parse(student['stud_scholarships']) : [];
        iframeDocument.getElementById("scholarship_font").innerHTML = scholarships.length !== 0 ? "Scholarships" : "";

        var futurePlans = [];
        if (student['stud_future_plans'] != "") {
            iframeDocument.getElementById("futurePlans_font").innerHTML = "Future plans";
            var s_plans = JSON.parse(student['stud_future_plans']);
            var s_plans_school = s_plans["f_plans_school"];
            var s_plans_course = s_plans["f_plans_course"];
            var s_plans_extra = s_plans["f_plans_extra"];

            futurePlans.push(s_plans_school, s_plans_course, s_plans_extra);
        } else {
            iframeDocument.getElementById("futurePlans_font").innerHTML = "";
        }

        for (var x = 0; x < awards.length; x++) {
            awardsHtml += "<li>" + awards[x] + "</li>";
        }
        
        memMomentsHtml += memMoments;
        
        for (var x = 0; x < scholarships.length; x++) {
            scholarshipsHtml += "<li>" + scholarships[x] + "</li>";
        }
        
        for (var x = 0; x < futurePlans.length; x++) {
            futurePlansHtml += "<li>" + futurePlans[x] + "</li>";
        }
        
        iframeDocument.getElementById("show_awards").innerHTML = awardsHtml;
        iframeDocument.getElementById("show_mem_moments").innerHTML = memMomentsHtml;
        iframeDocument.getElementById("show_future_plans").innerHTML = futurePlansHtml;
        iframeDocument.getElementById("show_scholarships").innerHTML = scholarshipsHtml;
    });
</script>
