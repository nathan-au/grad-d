<?php

    function createStudent($create_student_num, $create_student_email, $create_student_lname, $create_student_fname) {
        global $pdo;
        $q = $pdo -> prepare("INSERT INTO students (stud_num, stud_email, stud_lname, stud_fname) VALUES (:create_student_num, :create_student_email, :create_student_lname, :create_student_fname)");
        $q -> bindParam("create_student_num", $create_student_num);
        $q -> bindParam("create_student_email", $create_student_email);
        $q -> bindParam("create_student_lname", $create_student_lname);
        $q -> bindParam("create_student_fname", $create_student_fname);
        $q -> execute();
    }

    if (isset($_POST["create_student"])) {

        $create_student_num = $_POST["create_student_num"];
        $create_student_email = $_POST["create_student_email"];
        $create_student_lname = $_POST["create_student_lname"];
        $create_student_fname = $_POST["create_student_fname"];

        createStudent($create_student_num, $create_student_email, $create_student_lname, $create_student_fname);

    }

    if (isset($_POST["upload_students"])) {

        $file = fopen($_FILES['upload_students_file']['tmp_name'], "r");
        $data = $line = array();
        $i = 0;
        while (!feof($file)) {
            $line = fgetcsv($file);
            if ($line != "") {
                $data[$i] = $line;
                $i++;
            }
        }
        unset($data[0]);

        foreach ($data as $student) {

            $create_student_num = $student[0];
            $create_student_email = $student[1];
            $create_student_lname = $student[2];
            $create_student_fname = $student[3];
            createStudent($create_student_num, $create_student_email, $create_student_lname, $create_student_fname);
  
        }

    }
?>

<div class="row">
    <div class="col-4">
        <h4>Create Single Student</h4>

        <form action="" method="POST">
            <div class="form-floating mb-2">
                <input class="form-control" type="number" name="create_student_num" id="create_student_num" placeholder="student number" required> 
                <label for="create_student_num">Student number</label>
            </div>
            <div class="form-floating mb-2">
                <input class="form-control" type="email" name="create_student_email" id="create_student_email" placeholder="student email" required>
                <label for="create_student_email">Student email</label>
            </div>
            <div class="form-floating mb-2">
                <input class="form-control" type="text" name="create_student_fname" id="create_student_fname" placeholder="student first name" required>
                <label for="create_student_fname">Student first name</label>
            </div>
            <div class="form-floating mb-2">
                <input class="form-control" type="text" name="create_student_lname" id="create_student_lname" placeholder="student last name" required>
                <label for="create_student_lname">Student last name</label>
            </div>
            <input type="hidden" name="create_student">
            <input class="btn btn-primary" type="submit" value="Create student">
        </form>
    </div>

    <div class="col-4">
        <h4>Bulk Upload Multiple Students</h4>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-2">
                <input class="form-control" type="file" name="upload_students_file" id="upload_students_file">
                <label for="upload_students_file">Upload students csv file</label>
            </div>

            <input type="hidden" name="upload_students">
            <input class="btn btn-primary" type="submit" value="Upload students">
        </form>
    </div>
</div>