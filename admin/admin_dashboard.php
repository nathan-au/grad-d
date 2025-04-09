
<?php

    if (isset($_POST["delete_msg"])) {

        $delete_msg_id = $_POST["delete_msg_id"];

        $q = $pdo -> prepare("DELETE FROM messages WHERE msg_id = :delete_msg_id");
        $q -> bindParam("delete_msg_id", $delete_msg_id);
        $q -> execute();

    }

    $q = $pdo -> prepare("SELECT * FROM messages ORDER BY msg_id ASC");
    $q -> execute();
    $messages = $q -> fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-center"><b>West Carleton Grad System ADMIN</b></h1>

<?php 
require_once("../database.php");
$query = $pdo -> prepare("SELECT * FROM students WHERE stud_has_saved = 1");
$query -> execute();
$stud_saved = $query -> fetchALL(PDO::FETCH_ASSOC); 

$count = 0; 
foreach ($stud_saved as $s){
    $count += 1; 
}
echo "<h4># of Students who have saved: ". $count. "</h4>"; 
?> 


<h2>User Messages</h2>

<div class="row mb-2">
    <div class="col-2">
        <b>Student ID</b>
    </div>
    <div class="col-2">
        <b>Email</b>
    </div>
    <div class="col-8">
        <b>Message</b>
    </div>
</div>

<?php

    // print_r($messages);
    foreach ($messages as $message) {

        $msg_stud_id = $message["msg_stud_id"];
        $msg_id = $message["msg_id"];

        echo "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
            echo "<div class=\"row\">";

                echo "<div class=\"col-2\">";
                    if ($msg_stud_id != -1) {
                        echo "<a href=\"?page=admin_studentEdit.php&stud_id=$msg_stud_id\">$msg_stud_id</a>";
                    }
                    else {
                        echo $msg_stud_id;
                    }
                echo "</div>";
        
                echo "<div class=\"col-2\">".$message["msg_email"]."</div>";

                echo "<div class=\"col-8\">".$message["msg_text"]."</div>";

                $modal_id = "delete_message_modal_".$msg_id;

                echo "<button type=\"button\" class=\"btn-close\" data-bs-toggle=\"modal\" data-bs-target=\"#$modal_id\"></button>";

            echo "</div>";

        echo "</div>";

    
        echo "
            <div class=\"modal fade\" id=\"$modal_id\" tabindex=\"-1\" aria-hidden=\"true\">
                <div class=\"modal-dialog\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h1 class=\"modal-title fs-5\">Are you sure you want to delete this message?</h1>
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancel</button>
                            <form action=\"\" method=\"post\">
                                <input type=\"hidden\" name=\"delete_msg_id\" value=\"$msg_id\">
                                <input type=\"hidden\" name=\"delete_msg\">
                                <input class=\"btn btn-danger\" type=\"submit\" value=\"Delete message\">
                            </form>
                        </div>
                    </div>
                </div>
            </div>        
        ";       

    }
?>