<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<?php

    $stud_id = $_GET['stud_id'];

    if (isset($_POST['student_info'])) {
        
        $stud_num = $_POST['stud_num'];
        $q = $pdo -> prepare("UPDATE students SET stud_num = :stud_num WHERE stud_id = $stud_id");
        $q -> bindParam("stud_num", $stud_num);
        $q -> execute();

        $stud_email = $_POST['stud_email'];
        $q = $pdo -> prepare("UPDATE students SET stud_email = :stud_email WHERE stud_id = $stud_id");
        $q -> bindParam("stud_email", $stud_email);
        $q -> execute();

        $stud_lname = $_POST['stud_lname'];
        $q = $pdo -> prepare("UPDATE students SET stud_lname = :stud_lname WHERE stud_id = $stud_id");
        $q -> bindParam("stud_lname", $stud_lname);
        $q -> execute();

        $stud_fname = $_POST['stud_fname'];
        $q = $pdo -> prepare("UPDATE students SET stud_fname = :stud_fname WHERE stud_id = $stud_id");
        $q -> bindParam("stud_fname", $stud_fname);
        $q -> execute();

        $stud_css = $_POST['stud_css'];
        $q = $pdo -> prepare("UPDATE students SET stud_css = :stud_css WHERE stud_id = $stud_id");
        $q -> bindParam("stud_css", $stud_css);
        $q -> execute();

        $stud_moment = $_POST['memMoments'];
       $q = $pdo -> prepare("UPDATE students SET stud_mem_moment = :stud_moment WHERE stud_id = $stud_id");
       $q -> bindParam("stud_moment", $stud_moment);

       $q -> execute();

        $stud_plans_school = $_POST['stud_plans_school'];
        $stud_plans_course = $_POST['stud_plans_course'];
        $stud_plans_extra = $_POST['stud_plans_extra'];

        $stud_plans_arr = [];
        $stud_plans_arr["f_plans_school"] = $stud_plans_school;
        $stud_plans_arr["f_plans_course"] = $stud_plans_course;
        $stud_plans_arr["f_plans_extra"] = $stud_plans_extra;

        $stud_plans_str = json_encode($stud_plans_arr);
        $q = $pdo -> prepare("UPDATE students SET stud_future_plans = :stud_plans_str WHERE stud_id = :stud_id");
        $q -> bindParam("stud_plans_str", $stud_plans_str);
        $q -> bindParam("stud_id", $stud_id);
        $q -> execute();

    }

?>

<?php

    $query = $pdo -> prepare("SELECT * FROM students WHERE stud_id = :stud_id");
    $query -> bindParam("stud_id", $stud_id);
    $query -> execute();
    $stud = $query -> fetchALL(PDO::FETCH_ASSOC);

    $s_id = $stud[0]['stud_id'];
    $s_num = $stud[0]['stud_num'];
    $s_email = $stud[0]['stud_email'];
    $s_fname = $stud[0]['stud_fname'];
    $s_lname = $stud[0]['stud_lname'];
    $s_moment = $stud[0]['stud_mem_moment'];
    $s_scholarships = $stud[0]['stud_scholarships'];
    $s_awards = $stud[0]['stud_awards'];

    $s_show = $stud[0]['stud_which_show'];
    $s_enabled = $stud[0]['stud_enabled'];
    $s_css = $stud[0]['stud_css'];
    $s_saved = $stud[0]['stud_has_saved'];
    

    $s_plans = $stud[0]['stud_future_plans'];
    if (!empty($s_plans)) {
        $s_plans = json_decode($s_plans, true);
        $s_plans_school = $s_plans["f_plans_school"];
        $s_plans_course = $s_plans["f_plans_course"];
        $s_plans_extra = $s_plans["f_plans_extra"];
    }
    else {
        
        $s_plans_school = "blank";
        $s_plans_course = "blank";
        $s_plans_extra = "blank";
    }

    $query = $pdo -> prepare("SELECT * FROM awards");
    $query -> execute();
    $pre_awards = $query -> fetchALL(PDO::FETCH_ASSOC);

?>
<a href='?page=admin_studentList.php'>Go back to student list.</a>

<?php
    echo "<h1 style=\"text-align:center\">Slide content editor for ".$s_lname.", ".$s_fname."</h1>";
?>
<style>
    img{
        max-width: 100%;
    }

    .studIMG{
        padding: 50px;
        border-radius: 25px;
        border: 4px solid black;
        height: 300px;
        width: 200px;
        display: inline-block;
        padding: 1rem 1rem;
        vertical-align: middle;
        margin: 20px;
    }
    .imgUpload{
        text-align: center;
        width: 150px;
        margin-top: 50%;
        font-size: 10px;
        padding 5px;
        border: 4px solid black;
    }
    .studInfo{
        border-radius: 25px;
        padding: 10px;
        border: 4px solid black;
        width: 400px;
        height: 400px;


    }
    .memMom{
        width: 700px;
        float: right;
    }
    #studPicsDiv{
        align: center;
        display: flex;
        flex-direction: row;
    }
    #pic9{
        order: 1;
    }
    #pic10{
        order:2;
    }
    #pic11{
        order:3;
    }
    #pic12{
        order:4;
        
    }
    #pic13{
        order:5;
    }
    </style>
<?php
    echo "<div id = \"studPicsDiv\">";
        $target_dir = $_SERVER['DOCUMENT_ROOT'].'/gradD/studPics/';
        $files1 = scandir($target_dir);
          $files1 = array_slice(scandir($target_dir), 2);
            $grade = 9;
            $tempStr = "";

          for($i=0; $i<sizeof($files1); $i++) {
                $path = "gradD/studPics/".$files1[$i]."";
                $fileNameJPG = basename($path);
                $fileName = trim($fileNameJPG, ".jpg");

                $newName = explode ("_", $fileName);
                $gradePic =  $newName[0];
                $stud_idPic =  $newName[1];

                
            
                if ($stud_idPic == $s_id){
                    
                    $tempStr = $tempStr."_".$gradePic;

                    echo "<div id= \"pic".$gradePic."\" class = \"studIMG\">";
                    echo "<img src=\"../studPics/".$fileNameJPG."\" alt=\"".$fileNameJPG."\" >";
                    echo $fileNameJPG;
                    echo "</div>";

            //         echo "<div class=\"card border-success mb-3\" style=\"max-width: 18rem;\">";
            //    echo  "<div class=\"card-body text-success\">";
            //        echo "<h5 class=\"card-title\">Success card title</h5>";
            //      echo   "<p class=\"card-text\">Some quick example text to build on the card title and make up the bulk of the card's content.</p>";
            //    echo  "</div>"
            //     echo "<div class=\"card-footer bg-transparent border-success\">Footer</div>";
            //     echo "</div>";
                    

                }
        
          }
          for ($x = 9; $x <=13; $x++){
            if (str_contains($tempStr, $x)==false){
                echo "<div id = \"pic".$x."\" class=\"studIMG\">";
                    
                echo "<form method = \"POST\" id = \"picForm\"action = 'admin_uploads2.php?id=".$s_id."&grade=".$x."' enctype=\"multipart/form-data\">";
                // upload:
               
                 echo "<input type = \"hidden\" id = \"grade\" value = ".$x.">";
                 echo "<input type = \"hidden\" id = \"stud_id\" value = ".$s_id.">";
                 echo "<p class=\"text-center\">Upload ".$x."</p>";
                 //echo "<label for=\"fileToUpload\" class=\"btn btn-outline-primary\">Upload ".$x."</label>";
                 echo "<input  type='file' id='fileToUpload' name = 'fileToUpload' style=\"display:text\" ><br>";

                // echo "<div class=\"mb-3\">";
                // echo "<label for=\"formFileSm\" class=\"form-label\">Upload ".$x."</label>";
                // echo "<input class=\"form-control form-control-sm\" id='fileToUpload' type=\"file\">";
                // echo "</div>";
                echo "<input type='submit' class = \"btn btn-outline-secondary\" name=\"submit\" >";
                //echo "<button type =\"button\" onclick = \"sendPicData(".$s_id.", ".$x.")\"";
                echo "</form>";
       
                echo "</div>";
                
            }
          }

   // echo "</div>";

?>
<script type="text/javascript" src="upload2.js"></script>
<?php echo "</div>"; ?>




<form action="" method="POST">
<!-- <div class = "studInfo"> -->
    <div class = "row">

        <div class="card border-secondary mb-3" style="max-width: 18rem;">
        <div class="card-header">STUD INFO</div>
        <div class="card-body text-secondary">
        Student Number:
            <br>
            <input type="text" name="stud_num" value="<?php echo $s_num; ?>">
            <br>
            Email:
            <br>
            <input type="email" name="stud_email" value="<?php echo $s_email; ?>">
            <br>
            Last Name:
            <br>
            <input type="text" name="stud_lname" value="<?php echo $s_lname; ?>">
            <br>
            First Name:
            <br>
            <input type="text" name="stud_fname" value="<?php echo $s_fname; ?>">
            <br>
            CSS:
            <br>
             <input type = "text" name="stud_css" value ="<?php echo $s_css;?>">
             <br>
             please note that the input is only styling attributes and no id or class calls
            <input type="submit" name="submit" value = "save">
        </div>
        </div>

        <!-- </div> -->
            <div class = memMom>
            <!-- <input type="text" name="stud_moment" value="="> -->
            <script src="https://cdn.tiny.cloud/1/t03uf5ormjh22cia4fb49getjm982kfb7ddhy8izfr6o9zpf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
            <textarea id=memMoments name = memMoments ></textarea>
        <?php 

        // $s_moment = "hello";
        //   echo $s_moment;
            echo "<script>";
            echo "tinymce.init({";
            echo "selector: \"#memMoments\",";
        // echo "tinymce.activeEditor.setContent(".$s_moment.");";
        echo "setup : function(editor){";
        echo " editor.on(\"init\", function (){";
                echo "editor.setContent('".$s_moment."', {format: 'HTML'});";
            echo "});";
            echo "}";
            echo "});";
            echo "</script>";

        ?>
        <script>
        //  function characterCount() {
        //  const wordCount = tinymce.activeEditor.plugins.wordcount;
        //  alert(wordcount.body.getCharacterCountWithoutSpaces());
        // }
        // var buttonCount = document.getElementById('CharButton');
        // buttonCount.addEventListener('click', characterCount, false);
        
        // </script>
        <script>
            tinymce.activeEditor.setContent("""");
            tinymce.init({
            selector: '#memMoments',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            setup : function(editor){
                editor.on('init', function (e){
                    editor.setContent("''", {format: 'raw'});
                });
            }
            });
        </script>
            <input type="hidden" name="student_info">
            <!-- <input type="submit" value="Save Changes"> -->
        <?php echo "<input type = \"submit\" onclick = \"memMomSave(".$s_id.")\" value = \"Save Changes\">";?>
        

        </div>
    </div>
    <br>
    <div class = scholarshipDIV>
    Scholarships:

        <?php
        if ($s_scholarships !=NULL){
            $scholar = json_decode($s_scholarships, true);
                $numScholar = sizeof($scholar);
                $empty = 0;
    
            

         }
         else{
        
        $numScholar=0;
            $scholar = NULL;
            $empty = 1;
         }
       // $scholar = json_decode($s_scholarships, true);
        
        
        //echo $s_scholarships;
        //echo json_encode($scholar);
        // if($scholar != ""){
        //     $numScholar = sizeof($scholar);
        // }
        // else{
        //     $numScholar=0;
        // }
            
         //$numScholar = 4;
            for ($i=0; $i<$numScholar; $i++){
                echo "<div class=\"alert alert-primary alert-dismissible  fade show\" role=\"alert\">";
                    echo "".$scholar[$i]."";
                echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\" onclick = \"scholarRemove(".$i.", ".$s_id.")\"></button>";
                echo "</div>";
            }
           echo "<input id = \"scholarTxt\" type = \"text\" >";
           echo "<button type = \"button\" id = \"addScholar\"onclick = \"scholarAdd(".$s_id.", ".$empty.")\">ADD</button>"
            // <?php echo json_encode($scholar);

        ?>
       <script>
            function scholarAdd(stud_id, empty){
                //alert("hello3");
              //  alert($numScholar);
              var len = 0;
              if(empty == 0){
                var passedScholarArr = <?php echo json_encode($scholar);?> ;
                var passedScholarStr = JSON.stringify(passedScholarArr);
                var len = passedScholarArr.length;
              }
              
                
                // var passedScholarArr = <?php echo json_encode($scholar);?> ;
                // var passedScholarStr = JSON.stringify(passedScholarArr);
                // var len = passedScholarArr.length;
                // if ($scholar !=NULL){
                //     // var len = 0;
                //     // alert("hello");

                //     len = passedScholarArr.length;
                //     alert("hello2");
                // }
                // else{
                //     // len = passedScholarArr.length;
                //     // alert("hello2");
                //     var len = 0;
                //     alert("hello");
                // }
                //var changedScholarArr = new Array(passedScholarArr.length+1);
                var changedScholarArr = new Array(len+1);

              
              
             
                var x = 0;
                for (let j=0; j<len; j++ ){
                    
                        changedScholarArr[x] = passedScholarArr[j];
                        x++;   
                }
                if (document.getElementById('scholarTxt').value != ""){
               //changedScholarArr[passedScholarArr.length] = document.getElementById('scholarTxt').value;
                changedScholarArr[len] = document.getElementById('scholarTxt').value;

               
                
                var changedScholarStr = JSON.stringify(changedScholarArr);
               
                
               var xhttp = new XMLHttpRequest();    
     
               xhttp.open("GET", "admin_studentToggle.php?id="+stud_id+"&scholarAdd="+changedScholarStr);  
               xhttp.send(); 
               location. reload(); 
                }
           

            }

            function scholarRemove(i, stud_id){
                var passedScholarArr = <?php echo json_encode($scholar);?> 
                var passedScholarStr = JSON.stringify(passedScholarArr);
                var changedScholarArr = new Array(passedScholarArr.length-1);
                
                var x = 0;
                for (let j=0; j<passedScholarArr.length; j++ ){
                    if (i != j ){
                        changedScholarArr[x] = passedScholarArr[j];
                        x++;
                    }
                   
                    
                }
                var changedScholarStr = JSON.stringify(changedScholarArr);
                
                // alert (i);
                // alert (stud_id);
                // alert(passedScholarArr[i]);
                // alert (passedScholarStr);
            
         

      
        
      var xhttp = new XMLHttpRequest();    
     
     xhttp.open("GET", "admin_studentToggle.php?id="+stud_id+"&scholar="+changedScholarStr);   
 
        //  xhttp.onreadystatechange = function() {
            // if (this.readyState == 4 && this.status == 200) { //If state is correct and it doesn't error (404)

                
                    
                    // alert("hello 1");

                    //document.getElementById('studShowForm').submit();

                
            
                

        //  };

       xhttp.send(); 
    }
            
        </script>


    </div>


    <br>
    <!-- Awards:
   
    <div>
        <ul>
            <?php  

                echo "----".$s_awards."----";
                $awards = json_decode($s_awards, true);

                foreach($pre_awards as $pre){
                    echo "<option value = ".$pre['award_name']."> ".$pre['award_name']."</option>";
                }
            
            ?>
        

        </ul>


    </div>
    <div>
        <form method = "post" action = "">
            Add award:<br>
            <select name = "stud_add_award" onchange = "addAward()">
                <?php
                    

                    // foreach ($awards as $award){
                    //     echo "<li>";
                    //         echo $award;
                    //     echo "</li>";
                    // }
                ?>

            </select><br>
            <input type="text" name = "stud_add_award" placeholder = "add new award name"><br>
            <input type="submit"><br>

            Remove award:<br>
            <input type="text" name = "remove_award" placeholder = "remove award name"><br>
            <input type="submit"><br>

        </form>
    </div> -->
    <br>
    Future Plans:

    School <input type="text" name="stud_plans_school" value="<?php echo $s_plans_school; ?>">
    Course - <input type="text" name="stud_plans_course" value="<?php echo $s_plans_course; ?>">
    Extra - <input type="text" name="stud_plans_extra" value="<?php echo $s_plans_extra; ?>">


    <br>
    <input type="hidden" name="student_info">
    <input type="submit" value="Save Changes">

</form>
Awards:
    <!-- <input type="text" name="stud_awards" value="<?php //echo $s_awards; ?>" disabled> -->
    <div class = "awards">
        <ul>
            <?php  
             if ($s_awards !=NULL){
                $awards = json_decode($s_awards, true);
                    $numAwards = sizeof($awards);
                    $empty = 0;
        
                
    
             }
             else{
            
            $numAwards=0;
                $awards = NULL;
                $empty = 1;
                $numAwards = 0;
             }
      
                // $awards = json_decode($s_awards, true);

        //          if($awards != ""){
        //     $numAwards = sizeof($awards);
        // }
        // else{
        //     $numAwards=0;
        // }
            for ($i=0; $i<$numAwards; $i++){
                echo "<div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">";
                    echo "".$awards[$i]."";
                echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\" onclick = \"awardRemove(".$i.", ".$s_id.")\"></button>";
                echo "</div>";
            }
            echo "<input id = \"awardsTxt\" type = \"text\" >";
        //     echo "<label for=\"exampleDataList\" class=\"form-label\">Datalist example</label>";
        //     echo "<input class=\"form-control\" list=\"datalistOptions\" id = \"awardsTxt\" placeholder=\"Type to search...\">";
        //     echo "<datalist id=\"datalistOptions\">";
        //     foreach ($awards as $a){
        //         echo  "<option value=\"".$a['award_name']."\">";
        //     }
        //    echo  "</datalist>";
            echo "<button type = \"button\" id = \"addTxt\"onclick = \"awardAdd(".$s_id.", ".$empty.")\">ADD</button>";

        
                

                ?>
                  <!-- <form method = "post" action = "">
            Add award:<br>
            <select name = "stud_add_award" onchange = "addAward()">
                <?php
                    // foreach($pre_awards as $pre){
                    //     echo "<option value = ".$pre['award_name']."> ".$pre['award_name']."</option>";
                    // }
                ?>

            </select><br>
            <input type="text" name = "stud_add_award" placeholder = "add new award name"><br>
            <input type="hidden" name="change_add_awards">
             <input type="submit" value="ADD">
             <br>
             </form> -->
             <script>
                  function awardRemove(i, stud_id){
             
                 var passedAwardArr =  <?php echo json_encode($awards);?>
              //  var passedAwardStr = JSON.stringify(passedAwardArr);
           var changedAwardArr = new Array(passedAwardArr.length-1);
                
                var x = 0;
                for (let j=0; j<passedAwardArr.length; j++ ){
                    if (i != j ){
                        changedAwardArr[x] = passedAwardArr[j];
                        x++;
                    }
                   
                    
                }
                var changedAwardStr = JSON.stringify(changedAwardArr);

            
         

      
        
      var xhttp = new XMLHttpRequest();    
     
     xhttp.open("GET", "admin_studentToggle.php?id="+stud_id+"&awardRem="+changedAwardStr);   

       xhttp.send(); 
    }
    function awardAdd(stud_id, empty){
        var len = 0;
              if(empty == 0){
                var passedAwardArr = <?php echo json_encode($awards);?> ;
                var passedAwardStr = JSON.stringify(passedAwardArr);
                var len = passedAwardArr.length;
              }

// var passedAwardArr = <?php echo json_encode($awards);?> 
// var passedAwardStr = JSON.stringify(passedAwardArr);
var changedAwardArr = new Array(len+1);


var x = 0;
for (let j=0; j<len; j++ ){
    
        changedAwardArr[x] = passedAwardArr[j];
        x++;   
}
if (document.getElementById('awardsTxt').value != ""){
changedAwardArr[len] = document.getElementById('awardsTxt').value;


var changedAwardStr = JSON.stringify(changedAwardArr);

var xhttp = new XMLHttpRequest();    

xhttp.open("GET", "admin_studentToggle.php?id="+stud_id+"&awardAdd="+changedAwardStr);  
xhttp.send();  
location. reload();

}

}

                </script>
                <?php
        //   echo "<button type = \"button\" id = \"addScholar\"onclick = \"scholarAdd(".$s_id.")\">ADD</button>"
            // <?php echo json_encode($scholar);


              
            ?>
        

        </ul>


    </div>
    <div>

    <?php
            if(isset($_POST['change_add_awards'])){
                $stud_add_award = $_POST['stud_add_award'];
                array_push($awards,$stud_add_award);
                print_r ($awards);
               // $stud_award_str = json_encode($awards);
               $stud_award_str = json_encode($awards);
                echo  $stud_award_str;

                $q = $pdo -> prepare("UPDATE students SET stud_awards = :stud_award_str WHERE stud_id = :stud_id");
                $q -> bindParam("stud_award_str", $stud_award_str);
                $q -> bindParam("stud_id", $stud_id);
                $q -> execute();

            }
         

        ?>
       


    </div>
<!-- <scipt>
    function addAward(){

    }
</script> -->

<br>
<h2> Messages </h2>

<?php
    $query = $pdo -> prepare("SELECT * FROM messages WHERE msg_email = :stud_email");
    $query -> bindParam("stud_email", $s_email);
    $query -> execute();
    $message = $query -> fetchALL(PDO::FETCH_ASSOC);


    foreach ($message as $msg){
    echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">";
    echo $msg['msg_text'];
   // echo $msg['msg_id'];
    echo "<button type=\"button\" class=\"btn-close\" data-bs-toggle=\"modal\" data-bs-target=\"#staticBackdrop\" onclick = \"saveValue(".$msg['msg_id'].")\"></button>";
    //echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
    echo "</div>";
    }
?>

<script>

    function saveValue(msg_id){
       // alert(msg_id);
        window.value = msg_id;
    }
    const alertList = document.querySelectorAll('.alert')
    const alerts = [...alertList].map(element => new bootstrap.Alert(element))

    //  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>



    const bsAlert = new bootstrap.Alert('#myAlert')


</script>

<?php
    $query = $pdo -> prepare("SELECT * FROM logs WHERE log_user_id = :stud_id");
    $query -> bindParam("stud_id", $s_id);
    $query -> execute();
    $logs = $query -> fetchALL(PDO::FETCH_ASSOC);

    //<!-- Button trigger modal -->
        echo "<button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal\">";
        echo "see logs";
        echo "</button>";


    foreach ($logs as $l){
//     echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">";
//     echo $l['log_message'];
//    // echo $msg['msg_id'];
//     echo "<button type=\"button\" class=\"btn-close\" data-bs-toggle=\"modal\" data-bs-target=\"#staticBackdrop\" onclick = \"saveValue(".$l['msg_id'].")\"></button>";
//     //echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
//     echo "</div>";
    }
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><?echo $s_fname;?> logs</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        foreach($logs as $l){
            if ($l['log_user_id'] == $s_id){
            echo "<div class=\"alert alert-primary\" role=\"alert\">";
            echo $l['log_message'];
            echo $l['log_timestamp'];
          echo "</div>";
            }
        }

        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        Are you sure you want to remove this message?
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="dismissModal()" aria-label="Close">Yes</button>
    </div>
    </div>
</div>
</div>

<script>
    function dismissModal() {
        // var msgId =  
            
         
      //  alert (window.value);
      
        
      var xhttp = new XMLHttpRequest();    
     
     xhttp.open("GET", "admin_studentToggle.php?msgId="+window.value+"");   

       xhttp.send(); 
       location.reload();
       

        



}
    </script>
    <div id ="slides" style="height: 100%; overflow: hidden; align: center; ">
    <?php include ("stud_showPresent.php");?>
</div>





