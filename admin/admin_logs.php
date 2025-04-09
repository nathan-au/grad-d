<?php
    $query = $pdo -> prepare("SELECT * FROM logs ORDER BY log_timestamp DESC");
    $query -> execute();
    $logs = $query -> fetchALL(PDO::FETCH_ASSOC);
    // print_r($logs);
?> 

<h1>User Logs</h1> 
<div class="row mb-2">
    <div class="col"><b>User ID</b></div>
    <div class="col"><b>Timestamp</b></div>
    <div class="col"><b>Action</b></div>
    <div class="col"><b>User Type</b></div>
</div>

<?php
    foreach ($logs as $log) {
        echo "<div class=\"row border border-dark border-1 mb-2 p-1\">";
        if ($log["log_type"] == "STUDENT") {
            $stud_id = $log["log_user_id"];
            echo "<div class=\"col\"><a href=\"?page=admin_studentEdit.php&stud_id=$stud_id\">$stud_id</a></div>";
        }
        else {
            echo "<div class=\"col\">".$log["log_user_id"]."</div>";
        }
        echo "<div class=\"col\">".$log["log_timestamp"]."</div>";
        echo "<div class=\"col\">".$log["log_message"]."</div>";
        echo "<div class=\"col\">".$log["log_type"]."</div>";
        echo "</div>";
    }
?>