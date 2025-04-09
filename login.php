<?php 
    require("database.php");   
    require_once($_SERVER['DOCUMENT_ROOT'].'/google-auth/api.php');

    if (!google_isLoggedIn()) { 
        google_sendToAuth($redir=$_SERVER['PHP_SELF']);
        die();
    }
    else {
        $email = google_getUserEmail();    

        $q = $pdo -> prepare("SELECT * FROM admins WHERE admin_email = :email");
        $q -> bindParam("email", $email);
        $q -> execute();
        $admins = $q -> fetchAll(PDO::FETCH_ASSOC);

        $q = $pdo -> prepare("SELECT * FROM students WHERE stud_email = :email");
        $q -> bindParam("email", $email);
        $q -> execute();
        $students = $q -> fetchAll(PDO::FETCH_ASSOC);

        $q = $pdo -> prepare("SELECT * FROM settings");
        $q -> execute();
        $settings = $q -> fetchAll(PDO::FETCH_ASSOC);
        $student_login = $settings[1]['setting_value'];
    }        
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <div class="container mt-5">
            <?php
                if (count($admins) > 0) { //user is an admin and accepted
                    $user_id = $admins[0]['admin_id'];
                    $q = $pdo -> prepare("INSERT INTO logs (log_message, log_user_id, log_type) VALUES ('Login', :user_id, 'ADMIN')");
                    $q -> bindParam("user_id", $user_id);
                    $q -> execute();
                    header("Location: ./admin");
                }
                else if (count($students) > 0 && $student_login == "on") { //user is a student and accepted
                    $user_id = $students[0]['stud_id'];
                    $q = $pdo -> prepare("INSERT INTO logs (log_message, log_user_id, log_type) VALUES ('Login', :user_id, 'STUDENT')");
                    $q -> bindParam("user_id", $user_id);
                    $q -> execute();
                    header("Location: ./student");
                }
                else if (count($students) > 0 && $student_login == "off") { //user is a student and denied 
                    echo "<h1 class=\"text-center\">Error 403 - Forbidden</h1>";
                    echo "<p class=\"text-center\">Student login is currently disabled.<br>($email)</p>";    
                }
                else { //user is an opp and denied
                    echo "<h1 class=\"text-center\">Error 403 - Forbidden</h1>";
                    echo "<p class=\"text-center\">You don't have permission to access this page.<br>($email)</p>";
                }   
            ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.1.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    </body>
</html>