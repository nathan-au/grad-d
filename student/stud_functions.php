<?php
require("../database.php");
require("../mainFunctions.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/google-auth/api.php');

//FUNCTION CALL REDIRECT (ajax)
if(isset($_POST['func'])){
    $studID = getUserInfo('stud_id');
    if($_POST['func'] == 'submit'){
        func_saveInfo($studID);
        func_log($studID, "Info Updated");
    } elseif($_POST['func'] == 'report') {
        func_report($studID, $_POST['report_text']);
        func_log($studID, "Sent Report");
    } else {
        die("woops");
    }
}


function func_collectInfo($studID){
    global $pdo;
    $studInfo = [];
    $temp = [];

    $q = $pdo->prepare("SELECT stud_mem_moment, stud_scholarships, stud_future_plans FROM students WHERE stud_id=:studID");
    $q -> bindParam("studID", $studID);
    $q -> execute();
    $temp = $q->fetchAll(PDO::FETCH_ASSOC);

    //FORMAT MEM MOMENTS
    $studInfo["stud_mem_moment"] = $temp[0]["stud_mem_moment"];

    //FORMAT SCHOLARSHIPS
    if ((json_decode($temp[0]["stud_scholarships"])) == ""){ //CHECKS IF THERE'S ANYTHING IN THE DATABASE
        $studInfo["stud_scholarships"][0] = "";
    } else {
        $i = 0;
        foreach((json_decode($temp[0]["stud_scholarships"])) as $value){
            $studInfo["stud_scholarships"][$i] = $value;
            $i++;
        }
    }

    //FORMAT FUTURE PLANS
    if ((json_decode($temp[0]["stud_future_plans"])) == ""){ //CHECKS IF THERE'S ANYTHING IN THE DATABASE
        $studInfo["stud_future_plans"]["f_plans_school"] = "";
        $studInfo["stud_future_plans"]["f_plans_course"] = "";
    } else {
        // print_r(($temp[0]["stud_future_plans"]["f_plans_school"]));
        $studInfo["stud_future_plans"] = $temp[0]["stud_future_plans"];
    }
    return($studInfo);
}


function func_saveInfo($studID){
    global $pdo;
    $mem_moment = $_POST["edit_mem_moment"];
    $scholarships = json_encode(array_filter($_POST["edit_scholarships"]));
    $future_plans = json_encode($_POST["edit_future_plans"]);

    $q = $pdo->prepare("UPDATE students SET 
    stud_mem_moment = :stud_mem_moment, 
    stud_scholarships = :stud_scholarships,
    stud_future_plans = :stud_future_plans,
    stud_has_saved = 1
    WHERE stud_id=:studID");

    $q -> bindParam("stud_mem_moment", $mem_moment);
    $q -> bindParam("stud_scholarships", $scholarships);
    $q -> bindParam("stud_future_plans", $future_plans);
    $q -> bindParam("studID", getUserInfo('stud_id'));
    $q -> execute();
}


function func_log($studID, $action){
    global $pdo;
    $q = $pdo->prepare("INSERT INTO logs(log_message, log_user_id, log_type)
    VALUES (:msg, :id, \"STUDENT\")");

    $q -> bindParam("msg", $action);
    $q -> bindParam("id", $studID);
    $q -> execute();
}


function func_report($studID, $msg){
    global $pdo;
    $msg = $_POST['report_text'];
    $email = $_POST['report_email'];

    $q = $pdo->prepare("INSERT INTO messages(msg_email, msg_text, msg_stud_id)
    VALUES (:email, :msg, :id)");

    $q -> bindParam("msg", $msg);
    $q -> bindParam("email", $email);
    $q -> bindParam("id", $studID);
    $q -> execute();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function func_getSettingsInfo($setting_name){
    global $pdo;
    $temp = [];

    $q = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_name=:setting_name");
    $q -> bindParam("setting_name", $setting_name);
    $q -> execute();
    $temp = $q->fetchAll(PDO::FETCH_ASSOC);
    return($temp[0]["setting_value"]);
}

function func_checkEditPerm($returnValue){
    $value = func_getSettingsInfo("student_entry");
    if ($value == "off"){
        if($returnValue == "fieldset"){
            return("disabled");
        } elseif($returnValue == "tinyMCE") {
            return("readonly : true,");
        }
    }
    return(null);
}

function func_checkOpen(){
    $value = func_getSettingsInfo("student_login");
    if($value == "off"){
        return('<meta http-equiv="refresh" content="0; url=\'https://wcss.emmell.org/gradD/login.php\'" />');
    }
    return(null);
}
?>