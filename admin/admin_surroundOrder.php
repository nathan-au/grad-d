<?php
require("../database.php");

    $preArray = $_POST['preArray'];
    $disabledArray = $_POST['disabledArray'];
    $postArray = $_POST['postArray'];


    for ($x = 0; $x < count($preArray); $x++) {
        $q = $pdo->prepare("UPDATE `surroundingSlides` SET `surround_active`= '-1', `surround_order`= :x WHERE `surround_id` = :id;");
        $q->bindParam(":id", $preArray[$x]);
        $q->bindParam(":x", $x);
        $q->execute();
    }
    for ($x = 0; $x < count($disabledArray); $x++) {
        $q = $pdo->prepare("UPDATE `surroundingSlides` SET `surround_active` = '0', `surround_order` = :x WHERE `surround_id` = :id;");
        $q->bindParam(":id", $disabledArray[$x]);
        $q->bindParam(":x", $x);
        $q->execute();
    }
    for ($x = 0; $x < count($postArray); $x++) {
        $q = $pdo->prepare("UPDATE `surroundingSlides` SET `surround_active`= '1', `surround_order`= :x WHERE `surround_id` = :id;");
        $q->bindParam(":id", $postArray[$x]);
        $q->bindParam(":x", $x);
        $q->execute();
    }
?>
