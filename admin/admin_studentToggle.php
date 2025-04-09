<?php
    require("../database.php");

    echo "hello";
    

    // if(!isset($_GET['id'], $_GET['s'], $_GET['sID'])){
    //     die ("invalid");
    // }
    // if(isset($_GET['split'])){

    // }
    if(isset($_GET['msgId'])){
        $msg_id = $_GET['msgId'];
        echo ("-------".$msg_id);

        $q = $pdo->prepare("DELETE FROM `messages` WHERE msg_id = :msg_id ;");   
        $q->bindParam("msg_id",$msg_id);              
        $q->execute();

    }
    if(isset($_GET['id'], $_GET['awardAdd'])){
        $stud_id = $_GET['id'];
        $stud_awards= $_GET['awardAdd'];


        $q = $pdo->prepare("UPDATE `students` SET stud_awards = :sc  WHERE stud_id = :stud_id;");
        $q->bindParam("sc",$stud_awards);
        $q->bindParam("stud_id",$stud_id);                   
        $q->execute();

    }
    if(isset($_GET['id'], $_GET['awardRem'])){
        $stud_id = $_GET['id'];
        $stud_awards = $_GET['awardRem'];

        $q = $pdo->prepare("UPDATE `students` SET stud_awards = :sc  WHERE stud_id = :stud_id;");
        $q->bindParam("sc",$stud_awards);
        $q->bindParam("stud_id",$stud_id);                   
        $q->execute();
        

    }
    if(isset($_GET['id'], $_GET['scholarAdd'])){
        $stud_id = $_GET['id'];
        $stud_scholar = $_GET['scholarAdd'];

        $q = $pdo->prepare("UPDATE `students` SET stud_scholarships = :sc  WHERE stud_id = :stud_id;");
        $q->bindParam("sc",$stud_scholar);
        $q->bindParam("stud_id",$stud_id);                   
        $q->execute();

    }
    if(isset($_GET['id'], $_GET['scholar'])){
        $stud_id = $_GET['id'];
        $stud_scholar = $_GET['scholar'];

        $q = $pdo->prepare("UPDATE `students` SET stud_scholarships = :sc  WHERE stud_id = :stud_id;");
        $q->bindParam("sc",$stud_scholar);
        $q->bindParam("stud_id",$stud_id);                   
        $q->execute();
        

    }
    if(isset($_GET['id'], $_GET['s'], $_GET['sID'])){
    $stud_id = $_GET['id'];
    $state = $_GET['s'];
    $show_id = $_GET['sID'];

    $q = $pdo->prepare("UPDATE `students` SET stud_enabled= :s, stud_which_show = :show_id WHERE stud_id = :stud_id;");
    $q->bindParam("s",$state);
    $q->bindParam("stud_id",$stud_id);      
    $q->bindParam("show_id",$show_id);              
    $q->execute();
   }
    
    if(isset($_GET['id'],  $_GET['s'])){

        $stud_id = $_GET['id'];
        $state = $_GET['s'];

        $q = $pdo->prepare("UPDATE `students` SET stud_enabled= :s WHERE stud_id = :stud_id;");
        $q->bindParam("stud_id",$stud_id); 
        $q->bindParam("s",$state);                 
        $q->execute();

    }

    if(!isset($_GET['id'], $_GET['s'])){
        die ("invalid");
    }
   


?>