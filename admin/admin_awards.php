<?php

    //MANAGE STUDENT AWARDS

    function addStudentAward($stud_num, $award_name) {
        global $pdo;
        $q = $pdo -> prepare("SELECT stud_awards FROM students WHERE stud_num = :stud_num");
        $q -> bindParam("stud_num", $stud_num);
        $q -> execute();
        $students = $q -> fetchAll(PDO::FETCH_ASSOC);

        $stud_awards = $students[0]["stud_awards"];
        $stud_awards = json_decode($stud_awards);
        if (empty($stud_awards)) { //create new array if null array
            $stud_awards = [];
        }
        array_push($stud_awards, $award_name);
        $stud_awards = json_encode($stud_awards);

        $q = $pdo -> prepare("UPDATE students SET stud_awards = :stud_awards WHERE stud_num = :stud_num");
        $q -> bindParam("stud_awards", $stud_awards);
        $q -> bindParam("stud_num", $stud_num);
        $q -> execute();
    }



    if (isset($_POST["bulk_add_single_student_award"])) {

        $bulk_add_single_student_award_name_select = $_POST["bulk_add_single_student_award_name_select"];
        $bulk_add_single_student_award_name_custom = $_POST["bulk_add_single_student_award_name_custom"];

        if (!empty($bulk_add_single_student_award_name_custom)) {
            $bulk_add_single_student_award_name = $bulk_add_single_student_award_name_custom;
        }
        else {
            $bulk_add_single_student_award_name = $bulk_add_single_student_award_name_select;
        }

        if ($bulk_add_single_student_award_name != "0") {

            $bulk_add_single_student_award_students = $_POST["bulk_add_single_student_award_students"];
            $bulk_add_single_student_award_students = explode("\n", $bulk_add_single_student_award_students);
            $bulk_add_single_student_award_students = array_map('trim', $bulk_add_single_student_award_students);
    
            foreach($bulk_add_single_student_award_students as $bulk_add_single_student_award_student) {
                addStudentAward($bulk_add_single_student_award_student, $bulk_add_single_student_award_name);
            }

            echo "
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    AWARD $bulk_add_single_student_award_name SUCCESSFULLY ADDED TO STUDENTS                  
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";

        }



    }

    if (isset($_POST["bulk_add_multiple_student_awards"])) {
        $bulk_add_multiple_student_awards_students_awards = $_POST["bulk_add_multiple_student_awards_students_awards"];

        $bulk_add_multiple_student_awards_students_awards = explode("\n", $bulk_add_multiple_student_awards_students_awards);
        $bulk_add_multiple_student_awards_students_awards = array_map('trim', $bulk_add_multiple_student_awards_students_awards);
        $bulk_add_multiple_student_awards_students_awards = array_filter($bulk_add_multiple_student_awards_students_awards);
        print_r($bulk_add_multiple_student_awards_students_awards);

        foreach ($bulk_add_multiple_student_awards_students_awards as $bulk_add_multiple_student_awards_student_award) {

            if (strpos($bulk_add_multiple_student_awards_student_award, ',')) {
                $bulk_add_multiple_student_awards_student_award = explode(",", $bulk_add_multiple_student_awards_student_award);
                $bulk_add_multiple_student_awards_student_award = array_map('trim', $bulk_add_multiple_student_awards_student_award);
                // print_r($bulk_add_multiple_student_awards_student_award);
    
                $bulk_add_multiple_student_awards_student_num = $bulk_add_multiple_student_awards_student_award[0];
                $bulk_add_multiple_student_awards_award_name = $bulk_add_multiple_student_awards_student_award[1];
    
                addStudentAward($bulk_add_multiple_student_awards_student_num, $bulk_add_multiple_student_awards_award_name);

                echo "
                    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                        AWARDS SUCCESSFULLY ADDED TO STUDENTS                  
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    </div>
                ";
            }

        }

    }

    //MANAGE PRESET AWARDS

    if (isset($_POST["create_preset_award"])) {

        $create_preset_award_name = $_POST["create_preset_award_name"];
        $create_preset_award_name = trim($create_preset_award_name);
        $create_preset_award_is_always = $_POST["create_preset_award_is_always"];

        if ($create_preset_award_is_always == "on") {
            $create_preset_award_is_always = 1;
        }
        else {
            $create_preset_award_is_always = 0;
        }
        
        $q = $pdo -> prepare("INSERT INTO awards (award_name, award_is_always) VALUES (:create_preset_award_name, :create_preset_award_is_always)");
        $q -> bindParam("create_preset_award_name", $create_preset_award_name);
        $q -> bindParam("create_preset_award_is_always", $create_preset_award_is_always);
        $q -> execute();

        echo "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                PRESET STUDENT AWARD SUCCESSFULLY CREATED                  
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
        ";

    }

    if (isset($_POST["remove_preset_award"])) {
        if ($_POST["remove_preset_award_name"] != 0) {
            $remove_preset_award_name = $_POST["remove_preset_award_name"];
            $remove_preset_award_name = trim($remove_preset_award_name);
    
            $q = $pdo -> prepare("DELETE FROM awards WHERE award_name = :remove_preset_award_name");
            $q -> bindParam("remove_preset_award_name", $remove_preset_award_name);
            $q -> execute();

            echo "
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    PRESET STUDENT AWARD SUCCESSFULLY REMOVED                  
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
    }

?>

<h2>Manage Preset Awards</h2>
<div class="row">
    <div class="col-4">
        <h4>Preset Awards List</h4>
        <div class="border rounded border-1 pt-2">
            <ul>
                <?php
                    $q = $pdo -> prepare("SELECT * FROM awards");
                    $q -> execute();
                    $awards = $q -> fetchAll(PDO::FETCH_ASSOC);
                    foreach ($awards as $award) {
                        echo "<li>";
                        echo $award['award_name']." ".$award['award_is_always'];
                        echo "</li>";
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <h4>Create Preset Award</h4>

        <form action="" method="POST">
            <div class="form-floating mb-2">
                <input class="form-control" type="text" name="create_preset_award_name" id="create_preset_award_name" placeholder="create_preset_award_name" required>
                <label for="create_preset_award_name">Award name</label>
            </div>

            <div class="form-check form-switch mb-2">
                <input type="hidden" name="create_preset_award_is_always" value="0"/>
                <input class="form-check-input" role="switch" type="checkbox" name="create_preset_award_is_always" id="create_preset_award_is_always">
                <label for="create_preset_award_is_always">Set award_is_always</label>
            </div>
        
            <input type="hidden" name="create_preset_award">
            <input class="btn btn-primary" type="submit" value="Create preset award">
        </form>
    </div>
    <div class="col-3">
        <h4>Remove Preset Award</h4>

        <form action="" method="POST">
            <div class="mb-2">
                <select class="form-select" name="remove_preset_award_name">
                    <option value="0">-- select award --</option>
                    <?php
                        foreach ($awards as $award) {
                            $award_name = $award["award_name"];
                            echo "<option value=\"$award_name\">";
                            echo $award_name;
                            echo "</option>";
                        }
                    ?>
                </select>
            </div>

            <input type="hidden" name="remove_preset_award">
            <input class="btn btn-danger" type="submit" value="Remove preset award">
        </form>
    </div>
</div>
<br>
<h2>Bulk Add Student Awards</h2>

<div class="row">
    <div class="col-4"> 
        <h4>Bulk Add Single Student Award</h4>
        <form action="" method="POST">
            <div class="form-floating mb-1">
                <select class="form-select" name="bulk_add_single_student_award_name_select" id="bulk_add_single_student_award_name_select">
                    <option value="0">------ Select an award -----</option>
                    <?php
                        foreach ($awards as $award) {
                            if ($award["award_is_always"] != 1) {
                                $award_name = $award["award_name"];
                                echo "<option value=\"$award_name\">$award_name</option>";
                            }
                        }
                    ?>
                </select>
                <label for="bulk_add_single_student_award_name_select">Select award name</label>
            </div>
            <div class="text-center">
                OR
            </div>  
            <div class="form-floating mb-2 mt-1">
                <input class="form-control" type="text" name="bulk_add_single_student_award_name_custom" id="bulk_add_single_student_award_name_custom" placeholder="bulk_add_single_student_award_name_custom">
                <label for="bulk_add_single_student_award_name_custom">Custom award name</label>
            </div>
            <div class="form-floating mb-2">
                <textarea class="form-control" name="bulk_add_single_student_award_students" id="bulk_add_single_student_award_students" placeholder="bulk_add_single_student_award_students" style="height: 100px" required></textarea>
                <label for="bulk_add_single_student_award_students">List of student numbers</label>
            </div>
            <input type="hidden" name="bulk_add_single_student_award">
            <input class="btn btn-primary" type="submit" value="Bulk add single student award">
        </form>
    </div>
    <div class="col-5">
        <h4>Bulk Add Multiple Student Awards</h4>
        <form action="" method="POST">
            <div class="form-floating mb-2">
                <textarea class="form-control" name="bulk_add_multiple_student_awards_students_awards" id="bulk_add_multiple_student_awards_students_awards" placeholder="bulk_add_multiple_student_awards_students_awards" style="height: 100px" required></textarea>
                <label for="bulk_add_multiple_student_awards_students_awards">List of student numbers and award names (num, name)</label>
            </div>
            <input type="hidden" name="bulk_add_multiple_student_awards">
            <input class="btn btn-primary" type="submit" value="Bulk add multiple student awards">
        </form>
    </div>
</div>
    
<br>