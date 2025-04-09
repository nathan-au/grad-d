<?php
    if (isset($_GET["stud_id"]) && isset($_GET["stud_pics"])) {

        $stud_id = $_GET["stud_id"];
        $stud_pics = $_GET["stud_pics"];

        $stud_pics = explode(",", $stud_pics);

        require_once("../database.php");
        $q = $pdo -> prepare("SELECT * FROM students WHERE stud_id = :stud_id");
        $q -> bindParam("stud_id", $stud_id);
        $q -> execute();
        $student = $q -> fetchALL(PDO::FETCH_ASSOC);

        $stud_name = $student[0]['stud_lname'] . ", " . $student[0]['stud_fname'];

        $stud_pic_9_oldPath = $stud_pics[0];
        $stud_pic_10_oldPath = $stud_pics[1];
        $stud_pic_11_oldPath = $stud_pics[2];
        $stud_pic_12_oldPath = $stud_pics[3];
        $stud_pic_13_oldPath = $stud_pics[4];

        if ($stud_pic_9_oldPath != 1 && file_exists($stud_pic_9_oldPath)) {
            $stud_pic_9_newPath = "../studPics/9_".$stud_id.".jpg";
            rename($stud_pic_9_oldPath, $stud_pic_9_newPath);
        }
        if ($stud_pic_10_oldPath != 1 && file_exists($stud_pic_10_oldPath)) {
            $stud_pic_10_newPath = "../studPics/10_".$stud_id.".jpg";
            rename($stud_pic_10_oldPath, $stud_pic_10_newPath);
        }
        if ($stud_pic_11_oldPath != 1 && file_exists($stud_pic_11_oldPath)) {
            $stud_pic_11_newPath = "../studPics/11_".$stud_id.".jpg";
            rename($stud_pic_11_oldPath, $stud_pic_11_newPath);
        }
        if ($stud_pic_12_oldPath != 1 && file_exists($stud_pic_12_oldPath)) {
            $stud_pic_12_newPath = "../studPics/12_".$stud_id.".jpg";
            rename($stud_pic_12_oldPath, $stud_pic_12_newPath);
        }
        if ($stud_pic_13_oldPath != 1 && file_exists($stud_pic_13_oldPath)) {
            $stud_pic_13_newPath = "../studPics/13_".$stud_id.".jpg";
            rename($stud_pic_13_oldPath, $stud_pic_13_newPath);
        }

        $studPics = (scandir("../studPics"));
        unset($studPics[0]);
        unset($studPics[1]);

        $uploads = (scandir("../uploads"));
        unset($uploads[0]);
        unset($uploads[1]);

        echo "<div class=\"row\">";

        $stud_missing_photos = 0;
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
                // $stud_missing_photos++;
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

    }

?>