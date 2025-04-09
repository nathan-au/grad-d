<head>
    <style>
        /* Our two classes that we use to define the containers, and the draggable items themselves */
        .dragContainer {
            background-color:blue;
            padding:5px;
        }
        .draggableItem {
            border: 1px solid black;
            height:50px;
            margin:5px;
            text-align:center;
            background-color:white;
        }
        /* .gu classes related to the automate classes uses by dragula */
        .gu-mirror {
            position: fixed !important;
            margin: 0 !important;
            z-index: 9999 !important;
            opacity: 0.8;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
            filter: alpha(opacity=80);
        }
        .gu-hide {
            display: none !important;
        }
        .gu-unselectable {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }
        .gu-transit {
            opacity: 0.2;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
            filter: alpha(opacity=20);
        }
        .deleteSlide{
            cursor: pointer;
            color: red;
            margin-right: 10px;
            float: right;
            background: none;
            border: none;
            padding: 0;
        }

    </style>
  </head>
  <body> 

    <?php
    //DELETE SURROUND SLIDE  
    if (isset($_POST['surroundId'])){
        $surroundId = $_POST['surroundId']; 
        $q = $pdo->prepare("DELETE FROM `surroundingSlides` WHERE `surround_id` = :surroundId");
        $q->bindParam(":surroundId", $surroundId);
        $q->execute();
    }
    ?> 
        <br><br><br>
        <div class='container'>
            <div class='row'>
                <div class='col'><h3 class='text-center'><?php echo "<a href='admin_surroundSlidesPresent.php?id=" . "-1" . "' target='_blank'>" . "PRE SHOW" . "</a>"; ?></h3></div>
                <div class='col'><h3 class='text-center'>DISABLED SHOW</h3></div>
                <div class='col'><h3 class='text-center'><?php echo "<a href='admin_surroundSlidesPresent.php?id=" . "1" . "' target='_blank'>" . "POST SHOW" . "</a>"; ?></h3></div>
            </div>
            <div class='row'>
                <div class='col dragContainer m-1' id='preShow'>
                    <?php 
                        $query = $pdo -> prepare("SELECT * FROM surroundingSlides WHERE surround_active = -1 ORDER BY surround_order");
                        $query -> execute();
                        $preShow = $query -> fetchALL(PDO::FETCH_ASSOC); 
                        foreach ($preShow as $p){
                            echo "<div class='draggableItem' id='" . $p['surround_id'] . "' onclick='editPage(" . $p['surround_id'] . ")'>" . $p['surround_name'] . "
                            <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='surroundId' value='" . $p['surround_id'] . "'>
                                <button type='submit' class='deleteSlide'>&times;</button>
                            </form>
                            </div>";         
                            // echo "<div class='draggableItem' id=".$p['surround_id'].">".$p['surround_name']."</div>"; 
                            }
                    ?> 
                </div>
                <div class='col dragContainer m-1' id='disabledShow'>
                    <?php 
                        $query = $pdo -> prepare("SELECT * FROM surroundingSlides WHERE surround_active = 0 ORDER BY surround_order");
                        $query -> execute();
                        $disabledShow = $query -> fetchALL(PDO::FETCH_ASSOC); 
                        foreach ($disabledShow as $p){
                            echo "<div class='draggableItem' id='" . $p['surround_id'] . "' onclick='editPage(" . $p['surround_id'] . ")'>" . $p['surround_name'] . "
                            <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='surroundId' value='" . $p['surround_id'] . "'>
                                <button type='submit' class='deleteSlide'>&times;</button>
                            </form>
                            </div>";
                            // echo "<div class='draggableItem' id=".$p['surround_id'].">".$p['surround_name']."</div>"; 
                        }
                    ?> 
                </div>
                <div class='col dragContainer m-1' id='postShow'>
                    <?php 
                        $query = $pdo -> prepare("SELECT * FROM surroundingSlides WHERE surround_active = 1 ORDER BY surround_order");
                        $query -> execute();
                        $postShow = $query -> fetchALL(PDO::FETCH_ASSOC); 
                        foreach ($postShow as $p){
                            echo "<div class='draggableItem' id='" . $p['surround_id'] . "' onclick='editPage(" . $p['surround_id'] . ")'>" . $p['surround_name'] . "
                            <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='surroundId' value='" . $p['surround_id'] . "'>
                                <button type='submit' class='deleteSlide'>&times;</button>
                            </form>
                            </div>";
                            // echo "<div class='draggableItem' id=".$p['surround_id'].">".$p['surround_name']."</div>"; 
                        }
                    ?> 
                </div>
            </div>
        </div>
       <br>
        <div class='row'><div class='col text-center'>
            
        <form action="" method="POST">
  <a href="createSurroundSlide.php" class="btn btn-primary" name = "create" role="button">Create a surrounding slide</a>
  </form><br>
            <button class="btn btn-primary" onclick='describe()'>SAVE</button>
    </div></div>
    
    <script>
        //EDIT SURROUND SLIDE
        function editPage(surroundId){
            // surroundName = surroundingSlides[surroundId]['surround_name']; 
            window.location.href = 'admin_EditSurroundSlides.php?surroundId=' + surroundId;
        }
    </script> 

<!-- DRAGGING !--> 
  <script src='/dragula/dragula.min.js'></script>
  <script>
    var containers = [  
                        document.getElementById("preShow"),
                        document.getElementById("disabledShow"), 
                        document.getElementById("postShow")
                    ];
    
    function init() {        
        var draggy = dragula(containers, {
            copy: false,                       // elements are moved by default, not copied
            revertOnSpill: true,               // spilling will put the element back where it was dragged from, if this is true
            removeOnSpill: false               // spilling will `.remove` the element, if this is true
        });
    }

    function describe() {
        var outputText = "";

        var preArray = [];
        var disabledArray = [];
        var postArray = [];
       
        //PRE-SHOW SLIDES
        var children = document.getElementById("preShow").children;
        var numChildren = children.length;
        for (x=0;x<numChildren;x++) {
            preArray[x] = children[x].id;
        }

         //DISABLES SHOW SLIDES  
        var children = document.getElementById("disabledShow").children;
        var numChildren = children.length;
        for (x=0;x<numChildren;x++) {
            disabledArray[x] = children[x].id;
        }

        //POST-SHOW SLIDES 
        var children = document.getElementById("postShow").children;
        var numChildren = children.length;
        for (x=0;x<numChildren;x++) {
            postArray[x] = children[x].id;
        }
       
        $.ajax({
            url: 'admin_surroundOrder.php',
            type: 'POST',
            data: {
                preArray: preArray,
                disabledArray: disabledArray,
                postArray: postArray,
            },
            beforeSend: function() {
                console.log('AJAX request is being sent.');
            },
            success: function(response) {
                console.log('AJAX request was successful.');
                console.log('Response:', response);
            },
            error: function(xhr, status, error) {
                console.log('AJAX request encountered an error.');
                console.log('Error:', error);
            },
            complete: function() {
                console.log('AJAX request completed.');
            }
        });
 
        alert("saved");
    }
    init(); //after everything is all loaded and read, run the init function to start everything up.
 </script> 

<?php
    // echo "<a href='admin_surroundSlidesPresent.php?id=" . "-1" . "' target='_blank'>" . "Pre Show" . "</a>";
    // echo "<a href='admin_surroundSlidesPresent.php?id=" . "1" . "' target='_blank'>" . "Post Show ". "</a>";
?> 
 </body>