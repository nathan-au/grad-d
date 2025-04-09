<style>
    .s_id{
        width : 50px;
    }
    .s_name{
        width : 200px;
    }
    .dis{
        width : 50px;
    }
    .show_btn{
        width : 50px;

    }

</style>

<?php
    include ('../database.php');
   
    if(isset($_GET['search'])){
        $query = $pdo -> prepare("SELECT * FROM students WHERE stud_fname = \"".$_GET['search']."\"  OR stud_lname = \"".$_GET['search']."\"");
    }
    else {
        $query = $pdo -> prepare("SELECT * FROM students ORDER BY stud_lname, stud_fname ASC");
    }
    $query -> execute();
    $stud = $query -> fetchALL(PDO::FETCH_ASSOC);

    $query = $pdo -> prepare("SELECT * FROM shows");
    $query -> execute();
    $shows = $query -> fetchALL(PDO::FETCH_ASSOC); 

    $numShows = sizeof($shows);
    $numStuds = sizeof($stud);

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div>
    <form action = "" method = "get">
        <input type="hidden" name="page" value="admin_studentList.php">

        <input type = "text" name = "search">
        <input type = "submit" value = "search">

        <button type="button" onclick="location.href='?page=admin_studentList.php'">reset</button>
        <?php echo "<button type = \"button\" onclick = \"splitStud(".$numShows.", ".$numStuds.")\">split students</button>";?>
    </form>

</div>

<button class="btn btn-primary" type="button" onclick="location.href='?page=admin_manageStudents.php'">Manage students page</button>

<!-- <table class="table table-striped">
    <tr>
        <th>NAME</th>
        <th>ENABLED</th>

//DELETED PHP CALL DATABASE OF SHOWS
    </tr> -->
    <?php
        //  echo "<form method = \"post\" action = \"\">";
        //     echo "<div class = \"list-group\">";
        //         foreach ($stud as $s){
        //             //echo "<li>";
        //                 echo "<div class = \"row\">";
        //                     echo "<a href='https://wcss.emmell.org/gradD/admin/admin_styleNav.php?page=admin_studentEdit.php&stud_id=".$s['stud_id']."' class=\"list-group-item list-group-item-action\">".$s['stud_lname'] .", ". $s['stud_fname']."</a>";
        //                     echo  
                          
        //                     //  echo "<a href='?page=admin_studentEdit.php&stud_id=".$s['stud_id']."'>".$s['stud_lname'] .", ". $s['stud_fname']."</a>";

        //                 echo "</div>";

        //             //echo "</li>";

        //         }
        //     echo "</div>";

        echo "<form method = \"post\" action = \"\" id = \"studShowForm\">";
        // $numShows = sizeof($shows);
        // $numStud = sizeof($stud);
        $x=0;
            foreach ($stud as $s){
                $studIdArr[$x] = $s['stud_id'];
                echo "-------".$studIdArr[$x];
                $idCheck = 'dis-'.$s['stud_id'];
                $x++;
                
                $input =  "input type = \"checkbox\" id = '".$idCheck."'  ";

                if ($s['stud_enabled'] == 0)  {
                    $check = "checked = \"checked\"";
                }
                if ($s['stud_enabled'] ==1) {
                    $check = " ";
                }

          
               // echo "document.getElementById(".$idCheck.").checked = false";

                echo "<ul class=\"list-group list-group-horizontal\">";
                    echo "<li class=\"list-group-item\" style = width : 10%><div class = s_id>".$s['stud_id']."</div></li>";
                    echo "<li class=\"list-group-item\" style = width : 30%><div class = s_name>".$s['stud_lname'].", ".$s['stud_fname']."</div></li>";
                    // echo "<li class=\"list-group-item \" style = width : 5% onChange = 'disabled(".$s['stud_id'].", ".$s['stud_which_show'].")' ><div class = dis><input type = \"checkbox\" id = 'dis-".$s['stud_id']."' ".$check." ></div></li>";

                    echo "<li class=\"list-group-item \" style = width : 5% onChange = 'disabled(".$s['stud_id'].", ".$s['stud_which_show'].", ".$numShows.")' ><div class = dis><input type = \"checkbox\" id = 'dis-".$s['stud_id']."' ".$check." ></div></li>";
//                     <div class="form-check form-switch">
//   <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
//   <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
// </div>
                    $i = 0;
                        foreach ($shows as $c){
                            $showsIdArr[$i] = $c['show_id'];
                            
                           // echo "showId = ".$showsIdArr[$i];
                            $i++;
                            
                            $toggleBtn = "hello";

                            if ($s['stud_enabled']==1){

                                if ($c['show_id'] == $s['stud_which_show']){
                                     $toggleBtn = "<div id='status-".$s['stud_id']."-".$c['show_id']."'><img onclick='toggle(".$s['stud_id'].", 0, ".$c['show_id'].", ".$numShows.");' src = 'greenicon.png' height=30px></div>";
                                }
                                else {
                                    $toggleBtn =  "<div id='status-".$s['stud_id']."-".$c['show_id']."'><img onclick='toggle(".$s['stud_id'].", 1, ".$c['show_id'].", ".$numShows.");' src = 'redicon.png' height=30px></div>";
                                }
                               
                            }
                            else{
                                
                                $toggleBtn =  "<div id='status-".$s['stud_id']."-".$c['show_id']."'><img onclick='toggle(".$s['stud_id'].", 1, ".$c['show_id'].", ".$numShows.");' src = 'redicon.png' height=30px></div>";
                                
                            }

                            echo "<li class=\"list-group-item\" style = width : 10%><div class = show_btn>".$toggleBtn."</div></li>";
                        }
                echo "</ul>";
            }
        echo "</form>";

    
        
    ?>
<!-- </table> -->
    <!-- </body> -->
<script>
    function toggle(stud_id, state, show_id, numShows){
        var passedShowArr = <?php echo json_encode($showsIdArr);?>

        // for(let j = 0; j<numShows; j++){
        //     alert (passedShowArr[j]);
        // }
      //  alert ("hello");
        var xhttp = new XMLHttpRequest();                                        
        xhttp.open("GET", "admin_studentToggle.php?id="+stud_id+"&s="+state+"&sID="+show_id);  
 
        
       // alert("hello");
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) { //If state is correct and it doesn't error (404)
                if(state) {
                    
                    document.getElementById("status-"+stud_id+"-"+show_id).innerHTML = "<img onclick='toggle("+stud_id+",0,"+show_id+", "+numShows+")' src='greenicon.png' height=30>";
                    document.getElementById('dis-'+stud_id).checked = false;
     
                  
                    for( let i=0; i<numShows; i++){
                   
                      
    
                        if(passedShowArr[i]!=show_id){
                            document.getElementById("status-"+stud_id+"-"+passedShowArr[i]).innerHTML = "<img onclick='toggle("+stud_id+",1"+passedShowArr[i]+", "+numShows+")' src='redicon.png' height=30>";
                            
                            
                        }

                    }

                }
                else {
                    
                    document.getElementById("status-"+stud_id+"-"+show_id).innerHTML = "<img onclick='toggle("+stud_id+",1"+show_id+", "+numShows+")' src='redicon.png' height=30>";

                    document.getElementById('dis-'+stud_id).checked = true;
                }
                
            }
        };

        xhttp.send(); 
       
      //  xhttp.open(); 

    }
    function disabled(stud_id, show_id, numShows){
        
       // alert ("hello");
       // alert (document.getElementById('dis-'+stud_id).checked);
       var passedShowArr = <?php echo json_encode($showsIdArr);?> 
      
        
         var xhttp = new XMLHttpRequest();    
        
        xhttp.open("GET", "admin_studentToggle.php?id="+stud_id);   
    
         //  xhttp.onreadystatechange = function() {
             // if (this.readyState == 4 && this.status == 200) { //If state is correct and it doesn't error (404)

                if(document.getElementById('dis-'+stud_id).checked){
                    xhttp.open("GET", "admin_studentToggle.php?id="+stud_id+"&s=0");

                    for (let i = 0; i<numShows; i++){
                         if (passedShowArr[i]==show_id){
                         document.getElementById("status-"+stud_id+"-"+show_id).innerHTML = "<img  src='redicon.png' height=30>";
                    
                         }
                     }

                  // document.getElementById('studShowForm').submit();
                }
                else{
                    xhttp.open("GET", "admin_studentToggle.php?id="+stud_id+"&s=1");
                    for (let i = 0; i<numShows; i++){
                         if (passedShowArr[i]==show_id){
                         document.getElementById("status-"+stud_id+"-"+show_id).innerHTML = "<img  src='greenicon.png' height=30>";
                    
                         }
                     }

                   // alert("hello 1");

                   //document.getElementById('studShowForm').submit();

                }
             
                
   
        //  };

          xhttp.send(); 

   //}
}
    function splitStud(numShows, numStuds){
   
        var xhttp = new XMLHttpRequest(); 
        var passedStudIdArr = <?php echo json_encode($studIdArr);?>   
        var passedShowArr = <?php echo json_encode($showsIdArr);?>

        var x = 1; 
        var j = 0;
        var amt = Math.floor(numStuds/ numShows);
       for (let i=0; i<numShows; i++){
            for (j; j< amt * x;j++){
                toggle(passedStudIdArr[j], 1, passedShowArr[i], numShows);
            }
            j = amt * x;
            if (j > numStuds){
                break;
            }
            x++;
           
       }

     //   toggle(stud_id, state, show_id, numShows)
        
      //  xhttp.open("GET", "admin_studentToggle.php?split="1);   
    
         //  xhttp.onreadystatechange = function() {
             // if (this.readyState == 4 && this.status == 200) { //If state is correct and it doesn't error (404)


        //  };

        //  xhttp.send(); 

    }
</script>
