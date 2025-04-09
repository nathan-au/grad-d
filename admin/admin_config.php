<?php

    if (isset($_POST["save_settings"])) { //UPDATE SYSTEM SETTINGS

        $due_date = $_POST["due_date"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :due_date WHERE setting_id = 1");
        $q -> bindParam("due_date", $due_date);
        $q -> execute();

        $student_login = $_POST["student_login"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :student_login WHERE setting_id = 2");
        $q -> bindParam("student_login", $student_login);
        $q -> execute();

        $student_entry = $_POST["student_entry"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :student_entry WHERE setting_id = 3");
        $q -> bindParam("student_entry", $student_entry);
        $q -> execute();

        $login_messages = $_POST["login_messages"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :login_messages WHERE setting_id = 7");
        $q -> bindParam("login_messages", $login_messages);
        $q -> execute();

        $mem_mom_char_lim = $_POST["mem_mom_char_lim"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :mem_mom_char_lim WHERE setting_id = 4");
        $q -> bindParam("mem_mom_char_lim", $mem_mom_char_lim);
        $q -> execute();

        $slide_interval = $_POST["slide_interval"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :slide_interval WHERE setting_id = 5");
        $q -> bindParam("slide_interval", $slide_interval);
        $q -> execute();

        $default_photo_width = $_POST["default_photo_width"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :default_photo_width WHERE setting_id = 9");
        $q -> bindParam("default_photo_width", $default_photo_width);
        $q -> execute();

        $default_photo_height = $_POST["default_photo_height"];
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :default_photo_height WHERE setting_id = 10");
        $q -> bindParam("default_photo_height", $default_photo_height);
        $q -> execute();
        
        $display_info = $_POST["display_info"];
        $display_info = rtrim($display_info);
        $q = $pdo -> prepare("UPDATE settings SET setting_value = :display_info WHERE setting_id = 6");
        $q -> bindParam("display_info", $display_info);
        $q -> execute();

        echo "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                SYSTEM SETTING CHANGES SAVED                  
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
        ";

    }
    
    if (isset($_POST["create_admin"])) { //CREATE ADMIN

        $create_admin_name = $_POST["create_admin_name"];
        $create_admin_email = $_POST["create_admin_email"];
        
        $q = $pdo -> prepare("INSERT INTO admins (admin_name, admin_email) VALUES (:create_admin_name, :create_admin_email)");
        $q -> bindParam("create_admin_name", $create_admin_name);
        $q -> bindParam("create_admin_email", $create_admin_email);
        $q -> execute();

        echo "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                ADMIN $create_admin_name CREATED                 
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
        ";

    }

    if (isset($_POST["remove_admin"])) { //REMOVE ADMIN

        if ($_POST["remove_admin_email"] != 0) {
            $remove_admin_email = $_POST["remove_admin_email"];

            $q = $pdo -> prepare("DELETE FROM admins WHERE admin_email = :remove_admin_email");
            $q -> bindParam("remove_admin_email", $remove_admin_email);
            $q -> execute();
        }

        echo "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                ADMIN $remove_admin_email REMOVED                 
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
        ";

    }

    if (isset($_POST["system_reset"])) { //SYSTEM RESET

        // $q = $pdo -> prepare("DELETE FROM logs");
        // $q -> execute();

        // $q = $pdo -> prepare("DELETE FROM messages");
        // $q -> execute();

        // $q = $pdo -> prepare("DELETE FROM students");
        // $q -> execute();

        // $uploads = (scandir("../uploads"));
        // unset($uploads[0]);
        // unset($uploads[1]);

        // foreach ($uploads as $upload) {
        //     unlink("../uploads/".$upload);
        // }
    
        // $studPics = (scandir("../studPics"));
        // unset($studPics[0]);
        // unset($studPics[1]);
        
        // foreach ($studPics as $studPic) {
        //     unlink("../studPics/".$studPic);
        // }

        echo "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                SYSTEM SUCCESSFULLY RESET                 
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
        ";

    }

?>

<h2>System Settings</h2>
<?php
    $q = $pdo -> prepare("SELECT * FROM settings");
    $q -> execute();
    $settings = $q -> fetchAll(PDO::FETCH_ASSOC);
    $due_date = $settings[0]['setting_value'];
    $student_login = $settings[1]['setting_value'];
    $student_entry = $settings[2]['setting_value'];
    $mem_mom_char_lim = $settings[3]['setting_value'];
    $slide_interval = $settings[4]['setting_value'];
    $display_info = $settings[5]['setting_value'];
    $login_messages = $settings[6]['setting_value'];
    $default_photo_width = $settings[7]['setting_value'];
    $default_photo_height = $settings[8]['setting_value'];
?>

<form action="" method="POST" >
    <div class="row">
        <div class="col-3">

            <div class="form-check form-switch">
                <input type="hidden" name="student_login" value="off"/>
                <input class="form-check-input" role="switch" type="checkbox" name="student_login" id="student_login" <?php if ($student_login == "on") { echo "checked"; } ?>>
                <label for="student_login">Toggle student login</label>
            </div>
            
            <div class="form-check form-switch">
                <input type="hidden" name="student_entry" value="off"/>
                <input class="form-check-input" role="switch" type="checkbox" name="student_entry" id="student_entry" <?php if ($student_entry == "on") { echo "checked"; } ?>>
                <label for="student_entry">Toggle student data entry</label>
            </div>
            <div class="form-check form-switch">
                <input type="hidden" name="login_messages" value="off"/>
                <input class="form-check-input" role="switch" type="checkbox" name="login_messages" id="login_messages" <?php if ($login_messages == "on") { echo "checked"; } ?>>
                <label for="login_messages">Toggle login screen messages</label>
            </div>
            <div class="form-floating mb-2 mt-2">
                <input class="form-control" type="date" name="due_date" id="due_date" placeholder="due_date" value="<?php echo $due_date ?>">
                <label for="due_date">Submission due date</label>
            </div>
            <div class="form-floating mb-2">
                <input class="form-control" type="number" name="mem_mom_char_lim" id="mem_mom_char_lim" placeholder="mem_mom_char_lim" value="<?php echo $mem_mom_char_lim ?>">
                <label for="mem_mom_char_lim">Moment charater limit</label>
            </div>

        </div>
        <div class="col-3">

            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="slide_interval" id="slide_interval" placeholder="slide_interval" value="<?php echo $slide_interval ?>">
                <label for="slide_interval">Slide interval (in seconds)</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="default_photo_width" id="default_photo_width" placeholder="default_photo_width" value="<?php echo $default_photo_width ?>">
                <label for="default_photo_width">Default photo width</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="default_photo_height" id="default_photo_height" placeholder="default_photo_height" value="<?php echo $default_photo_height ?>">
                <label for="default_photo_height">Default photo height</label>
            </div>

        </div>
        <div class="col-6">
            <div class="form-floating mt-2">
                <textarea class="form-control overflow-hidden" name="display_info" id="display_info" maxlength="200" style="height: 175px; resize: none"><?php echo $display_info ?></textarea>
                <label for="display_info">Display information (maxlength 200)</label>
            </div>
        </div>
    </div>
    <input type="hidden" name="save_settings">
    <button class="btn btn-primary" type="submit">Save changes</button>
</form>

<br>

<h2>Manage Admins</h2>
<div class="row">
    <div class="col-3">
        <h4>List of Admins</h4>
        <div class="border rounded border-1 pt-2">
            <ul>
                <?php
                    $q = $pdo -> prepare("SELECT * FROM admins");
                    $q -> execute();
                    $admins = $q -> fetchAll(PDO::FETCH_ASSOC);
                    foreach ($admins as $admin) {
                        $admin_email = $admin['admin_email'];
                        echo "<li>";
                        echo $admin_email;
                        echo "</li>";
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <h4>Create Admin</h4>
        <form action="" method="POST">
            <div class="form-floating mb-2">
                <input class="form-control" type="text" name="create_admin_name" id="create_admin_name" placeholder="create_admin_name" required>
                <label for="create_admin_name">Admin name</label>
            </div>
            <div class="form-floating mb-2">
                <input class="form-control" type="email" name="create_admin_email" id="create_admin_email" placeholder="create_admin_email" required>
                <label for="create_admin_email">Admin email</label>
            </div>
            <input type="hidden" name="create_admin">
            <input class="btn btn-primary" type="submit" value="Create admin">
        </form>
    </div>
    <div class="col-3">
        <h4>Remove Admin</h4>
        <form action="" method="POST">
            <div class="mb-2">
                <select class="form-select" name="remove_admin_email" id="remove_admin_email">
                    <option value="0">-- select admin --</option>
                    <?php
                        foreach ($admins as $admin) {
                            $admin_email = $admin['admin_email'];
                            echo "<option value=\"$admin_email\">";
                            echo $admin_email;
                            echo "</option>";
                        }
                    ?>
                </select>
            </div>
            <input type="hidden" name="remove_admin">
            <input class="btn btn-danger" type="submit" value="Remove admin">
        </form>
    </div>
</div>

<br>

<form action="" method="POST">
    <h4>System Reset</h4>
    <input class="btn btn-danger" type="submit" name="system_reset" id="system_reset" value="RESET SYSTEM" id="" onclick="return confirm('WARNING: This action cannot be undone. All student, log, message and image data will be deleted.');">
</form>
<br>