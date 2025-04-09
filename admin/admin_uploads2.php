<?php 

    $grade = $_GET['grade'];
    $stud_id = $_GET['id'];

    echo $grade;
    echo $stud_id;

    $target_dir = $_SERVER['DOCUMENT_ROOT'].'/gradD/studPics/';
    $target_file = $target_dir . $grade."_".$stud_id.".jpg";
    $temp = $_FILES["fileToUpload"]['tmp_name'];
    echo "-----".$target_file."----";

    if (move_uploaded_file($_FILES["fileToUpload"]['tmp_name'], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["tmp_name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
       header("Location:https://wcss.emmell.org/gradD/admin/?page=admin_studentEdit.php&stud_id=".$stud_id."");
       //header("Location:../gradD/admin/?page=admin_studentEdit.php&stud_id=".$stud_id."");

?>