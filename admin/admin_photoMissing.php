<?php
    if (isset($_GET["sort"])) {
        if ($_GET["sort"] == "Name") {
            $q = $pdo -> prepare("SELECT stud_id, stud_num, stud_email, stud_lname, stud_fname FROM students ORDER BY stud_lname, stud_fname ASC");
        }
        else if ($_GET["sort"] == "ID") {
            $q = $pdo -> prepare("SELECT stud_id, stud_num, stud_email, stud_lname, stud_fname FROM students ORDER BY stud_id ASC");
        }
    }
    else {
        $q = $pdo -> prepare("SELECT stud_id, stud_num, stud_email, stud_lname, stud_fname FROM students ORDER BY stud_lname, stud_fname ASC");
    }

    $q -> execute();
    $students = $q -> fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Missing Photos</h1>
Assigned photos will be renamed (format: grade_studID) and moved to the studPics folder.

<?php 

    $total_photos = count($students) * 5;
    $missing_photos = 0;

    $studPics = (scandir("../studPics"));
    unset($studPics[0]);
    unset($studPics[1]);

    foreach ($students as $student) {
        $stud_id = $student['stud_id'];
        for ($g = 9; $g <= 13; $g++) {
            $stud_pic = $g . "_" . $stud_id . ".jpg";
            if (in_array($stud_pic, $studPics) == false) {
                $missing_photos++;
            }
        }
    }

    $percent_missing = floor(($missing_photos / $total_photos) * 100);
    $percent_linked = 100 - $percent_missing;
    $percent_missing = $percent_missing . "%";
    $percent_linked = $percent_linked . "%";

?>

<div class="progress mt-2 mb-2" style="height: 30px">
    <div class="progress-bar bg-success" <?php echo "style=\"width:$percent_linked\""?>>
        <?php echo "Linked photos ($percent_linked)"?>

    </div>
    <div class="progress-bar bg-danger" <?php echo "style=\"width:$percent_missing\""?>>
        <?php echo "Missing photos ($percent_missing)"?>
    </div>
</div>

<form action="" method="get">
    
    <input type="hidden" name="page" value="admin_photoMissing.php">
    <div class="btn-group" role="group">
        <button class="btn" disabled>Sort by:</button>
        <input class="btn btn-outline-dark <?php if (isset($_GET["sort"]) && $_GET["sort"] == "Name") {echo "active";} ?>" type="submit" name="sort" value="Name">
        <input class="btn btn-outline-dark <?php if (isset($_GET["sort"]) && $_GET["sort"] == "ID") {echo "active";} ?>" type="submit" name="sort" value="ID">
    </div>
    
</form>

<div class="row ms-1 mb-2 mt-2">
    <div class="col-1"></div>
    <div class="col-2"><b>Name</b></div>
    <div class="col-1"><b>ID</b></div>
    <div class="col-1"><b>Year 9</b></div>
    <div class="col-1"><b>Year 10</b></div>
    <div class="col-1"><b>Year 11</b></div>
    <div class="col-1"><b>Year 12</b></div>
    <div class="col-1"><b>Grad</b></div>
</div>

<?php 

    $uploads = (scandir("../uploads"));
    unset($uploads[0]);
    unset($uploads[1]);

    $studPics = (scandir("../studPics"));
    unset($studPics[0]);
    unset($studPics[1]);
    
    echo "<ul class=\"list-group\">";
    foreach ($students as $student) {

        $stud_missing_photos = 0;

        $stud_name = $student['stud_lname'] . ", " . $student['stud_fname'];
        $stud_id = $student['stud_id'];

        $list_item_id = "stud_" . $stud_id;

        echo "<li class=\"list-group-item\" id=\"$list_item_id\">";

        echo "<div class=\"row\">";

        for ($g = 9; $g <= 13; $g++) {
            $stud_pic = $g . "_" . $stud_id . ".jpg";
            if (in_array($stud_pic, $studPics) == false) {
                $stud_missing_photos++;
            }
        }
        $stud_percent_missing = floor(($stud_missing_photos / 5) * 100);
        $stud_percent_linked = 100 - $stud_percent_missing;
        $stud_percent_missing = $stud_percent_missing . "%";
        $stud_percent_linked = $stud_percent_linked . "%";

        echo "<div class=\"col-1\">";
        echo "
            <div class=\"progress\" style=\"height: 20px\">
                <div class=\"progress-bar bg-success\" style=\"width:$stud_percent_linked\"></div>
                <div class=\"progress-bar bg-danger\" style=\"width:$stud_percent_missing\"></div>
            </div>
        ";
        echo "</div>";
        
        echo "
            <div class=\"col-2\">
                <a href=\"?page=admin_studentEdit.php&stud_id=$stud_id\" target=\"_blank\">$stud_name</a>
            </div>
        ";      
          
        echo "<div class=\"col-1\">$stud_id</div>";

        for ($g = 9; $g <= 13; $g++) {
            echo "<div class=\"col-1\">";
            
            $stud_pic = $g . "_" . $stud_id . ".jpg";
            if (in_array($stud_pic, $studPics) == true) {
                echo "<a href=\"../studPics/$stud_pic\" target=\"_blank\">$stud_pic</a>";
            }
            else {

                $select_name = "stud_pic_" . $g . "_" . $stud_id;
                $select_id = $select_name;
                echo "<select class=\"form-select\" name=\"$select_name\" id=\"$select_id\">";
    
                    echo "<option value=\"0\">---</option>";
                    foreach ($uploads as $upload) {
                        $uploadPath = "../uploads/$upload";
                        $uploadImageType = exif_imagetype($uploadPath);
                        if ($uploadImageType == IMAGETYPE_JPEG || $uploadImageType == IMAGETYPE_PNG) {
                            echo "<option value=\"$uploadPath\">$upload</option>";
                        }
                    }
                echo "</select>";
            }
            echo "</div>";

        }
        
        echo "<div class=\"col-1\">";
        if ($stud_percent_linked != "100%") {
            echo "<button class='btn btn-primary' onclick='assignPhotos($stud_id)' type='button'>Save</button>";
        }
        echo "</div>";

        echo "</div>";

        echo "</li>";
    }
    echo "</ul>";

    
?>

<script>
    function assignPhotos(stud_id) {

        var updateListItem = document.getElementById("stud_"+stud_id);
        stud_id = stud_id.toString();
        console.log(stud_id);
        
        const stud_pics = [];
        
        for (var g = 9; g <= 13; g++) {
            if (document.getElementById("stud_pic_"+g+"_"+stud_id) != null) {
                var stud_pic = document.getElementById("stud_pic_"+g+"_"+stud_id).value;
                stud_pics.push(stud_pic);
            }
            else {
                stud_pics.push("1");
            }
        }

        console.log(stud_pics);

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                updateListItem.innerHTML = this.responseText;
            }
        };

      xhttp.open("GET", "admin_photoAssign.php?stud_id="+stud_id+"&stud_pics="+stud_pics);
      xhttp.send();

    }
</script>