<?php

require("../database.php");
  
  $query = $pdo -> prepare("SELECT * FROM students");
  $query -> execute();
  $stud = $query -> fetchALL(PDO::FETCH_ASSOC);
   
    //define ('SITE_ROOT', realpath(dirname(__FILE__)));
    $target_dir = $_SERVER['DOCUMENT_ROOT'].'/gradD/uploads/';
    $new_dir = $_SERVER['DOCUMENT_ROOT'].'/gradD/studPics/';
    echo $target_dir;
    echo "<br>";
   
    $target_file = $target_dir . $_FILES['fileToUpload']["name"];
    //$target_file = $target_dir . "year.zip";

    echo $target_file;
    echo "<br>";

    $temp = $_FILES["fileToUpload"]['tmp_name'];
    echo $temp;
    $errorCheck = 1;
   // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // if(isset($_POST["submit"])) {
    //     echo "hello";
    //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //     if($check !== false) {
    //       echo "File is an image - " . $check["mime"] . ".";
    //       $errorCheck = 1;
    //     } else {
    //       echo "File is not an image.";
    //       $errorCheck = 0;
    //     }
    //   }

    //   if ($errorCheck == 0) {
    //     echo "Sorry, your file was not uploaded.";
    //   // if everything is ok, try to upload file
    //   } else {
        if (move_uploaded_file($_FILES["fileToUpload"]['tmp_name'], $target_file)) {
          echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
    //}

          $zip = new ZipArchive;
      if ($zip->open($target_file) === TRUE) {
          $zip->extractTo($target_dir);
          $zip->close();
          echo 'ok';
      } else {
          echo 'failed';
      }

    
      $files1 = scandir($target_dir);
      $files1 = array_slice(scandir($target_dir), 2);
      //print_r($files1);
      echo "<br>";

    // $query = $pdo -> prepare("SELECT * FROM students");
    // $query -> execute();
    // $stud = $query -> fetchALL(PDO::FETCH_ASSOC);

    //$path = "gradD/uploads/Grant Shaun.jpg";
  
   // $file1 = basename($path);

   if (isset($_GET['grade'], $_GET['fileNameType'])){
    $grade = $_GET['grade'];
    $name = $_GET['fileNameType'];

  


    //move_uploaded_file($target_dir."Bruneau Alexander.jpg", $new_dir . "linh.jpg");

    

      for($i=0; $i<sizeof($files1); $i++) 
      {
        
        $path = "gradD/uploads/".$files1[$i]."";
        $fileName = basename($path);
          if (str_contains($fileName, ' ') ){
            $fileName = trim($fileName, ".jpg");
            $fileName = trim($fileName, ".JPG");
            //echo $fileName;

            if ($name == "lsf"){

              $newName = explode (" ", $fileName);
              $fname =  $newName[1];
              $lname =  $newName[0];
            }
            if ($name == "fsl"){

              $newName = explode (" ", $fileName);
              $fname =  $newName[0];
              $lname =  $newName[1];
            }
            if ($name == "fcl"){

              $newName = explode (", ", $fileName);
              $fname =  $newName[0];
              $lname =  $newName[1];
            }
            if ($name == "lcf"){

              $newName = explode (", ", $fileName);
              $fname =  $newName[1];
              $lname =  $newName[0];
            }
            foreach ($stud as $s){
                if (strcmp(strtolower($fname), strtolower($s['stud_fname'])) == 0 && strcmp(strtolower($lname), strtolower($s['stud_lname'])) == 0 ){
                  $stud_id = $s['stud_id'];
                  $newFileName = $grade."_".$stud_id.".jpg";

                  
                  copy($target_dir.basename($path), $new_dir . $newFileName);
                  unlink ($target_dir.basename($path));
                }
                else{
                  //echo "Unknown |". basename($path)."|, ";
                  echo "<br>";
                  echo "|".strtolower($fname)."|=|".strtolower($s['stud_fname'])."|";
                  echo "--";
                  echo "|".strtolower($lname)."|=|".strtolower($s['stud_lname'])."|";
                  echo "<br>";

                  //copy($target_dir.basename($path), $new_dir . basename($path));
                }
              
            }

        }
  

      }

    }

?>
