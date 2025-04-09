<?php
    // DELETE SURROUND SLIDE  
    // if (isset($_GET['showId'])){
        require("../database.php");

        $showId = $_GET['showId']; 
        $q = $pdo->prepare("DELETE FROM `shows` WHERE `show_id` = :showId");
        $q->bindParam(":showId", $showId);
        $q->execute();
    // }
    ?> 