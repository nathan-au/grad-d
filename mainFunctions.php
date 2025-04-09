<?php
    
    function verifyLogin($validUserType) {
        
        if (google_isLoggedIn()) {

            $email = google_getUserEmail();
            global $pdo;
            $q = $pdo -> prepare("SELECT * FROM admins WHERE admin_email = :email");
            $q -> bindParam("email", $email);
            $q -> execute();
            $admins = $q -> fetchAll(PDO::FETCH_ASSOC);
        
            if (count($admins) > 0) {
                $user = "admin";
            }
            else {
                $q = $pdo -> prepare("SELECT * FROM students WHERE stud_email = :email");
                $q -> bindParam("email", $email);
                $q -> execute();
                $students = $q -> fetchAll(PDO::FETCH_ASSOC);
            
                if (count($students) > 0) {
                    $user = "student";
                }   
                else {
                    $user = "opp";
                }        
            }

            if ($user != $validUserType) {
                echo "<h1 class=\"text-center\">Error 403 - Forbidden</h1>";
                echo "<p class=\"text-center\">You don't have permission to access this page lol.<br>($email)</p>";
                die();
            }
        }
        else {
            header("Location: https://wcss.emmell.org/gradD/login.php");
        }
    }

    function getUserInfo($info_type) { //argument example -> "admin_id" "stud_fname"

        $user_type = substr($info_type, 0, 1);

        $user_email = google_getUserEmail();
        global $pdo;

        if ($user_type == "s") {
            $q = $pdo -> prepare("SELECT $info_type FROM students WHERE stud_email = :user_email");
        }
        else if ($user_type == "a") {
            $q = $pdo -> prepare("SELECT $info_type FROM admins WHERE admin_email = :user_email");
        }

        $q -> bindParam("user_email", $user_email);
        $q -> execute();
        $userInfo = $q -> fetchAll(PDO::FETCH_ASSOC);

        return $userInfo[0][$info_type];

    }












?>