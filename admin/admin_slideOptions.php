<style>
    /* .deleteSlide {
      cursor: pointer;
      color: red;
      margin-right: 10px;
      float: right;
      background: none;
      border: none;
      padding: 0;
    } */
  </style>
<body> 
<?php
    //DELETE SURROUND SLIDE  
    if (isset($_POST['showId'])){
        $showId = $_POST['showId']; 
        $q = $pdo->prepare("DELETE FROM `shows` WHERE `show_id` = :showId");
        $q->bindParam(":showId", $showId);
        $q->execute();
    }
    ?> 
<br><br>
<form action="" method="POST" style = "width: 400px">
  <div class="form-floating mb-2">
    <input class="form-control" type="text" name="addlongname" id="addlongname" placeholder="Name show" required>
    <label for="addlongname">Give the new show a Long name</label>
  </div>

  <div class="form-floating mb-2">
    <input class="form-control" type="text" name="addshortname" id="addshortname" placeholder="Name show" required>
    <label for="addshortname">Give the new show a Short name</label>
  </div>

  <input type="hidden" name="addShow"><input class="btn btn-primary" type="submit" value="Add a show">
 </form>

<?php 
if (isset($_POST['addShow'])) {
  $addshortname = $_POST['addshortname'];
  $addlongname = $_POST['addlongname'];

  $q = $pdo->prepare("SELECT MAX(show_id) as max_id FROM shows");
  $q->execute();
  $result = $q->fetch(PDO::FETCH_ASSOC);
  $newShowId = $result['max_id'] + 1;

  $q = $pdo->prepare("INSERT INTO shows (show_id, show_long_name, show_short_name) VALUES (:newShowId, :addlongname, :addshortname)");
  $q->bindParam(":newShowId", $newShowId);
  $q->bindParam(":addshortname", $addshortname);
  $q->bindParam(":addlongname", $addlongname);
  $q->execute();
}

$query = $pdo->prepare("SELECT * FROM shows");
$query->execute();
$shows = $query->fetchAll(PDO::FETCH_ASSOC); 
?> 
<br>

<div class="btn-group" role="group" aria-label="Basic mixed styles example">
  <a href="admin_fullShow.php?>" class="btn btn-primary show-link" tabindex="-1" role="button" target="_blank">
    <?php echo "Launch Full Show" ?>
  </a>
</div>

<?php 
foreach ($shows as $show) {
  echo "
  <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
  <a href='admin_showPresent.php?id=" . $show['show_id'] . "' class='btn btn-primary show-link' tabindex='-1' role='button' target='_blank'>" . $show['show_long_name'] . "</a>
  <button type='button' class='btn btn-danger delete-button' data-bs-toggle='modal' data-bs-target='#deleteModal" . $show['show_id'] . "'>&times;</button>
</div>

<!-- Modal -->
<div class='modal fade' id='deleteModal" . $show['show_id'] . "' tabindex='-1' aria-labelledby='deleteModalLabel" . $show['show_id'] . "' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='deleteModalLabel" . $show['show_id'] . "'>Delete Show</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
        Are you sure you want to delete this show?
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
        
        <form action='' method='post'>
        <input type='hidden' name='showId' value='" . $show['show_id'] . "'>
        <button class='btn btn-danger' type='submit'>Delete Show</button>
    </form>
      </div>
    </div>
  </div>
</div>
 ";
}
?>

<!-- /////////////////////PICTURES OF STUDENTS AND FINSIHED SLIDES HERE /////////////////////!--> 
<!-- <button type="button" class="btn btn-primary" tabindex="-1" role="button" onclick="window.open('admin_preCachePics.php', '_blank')">Load Precache Pics</button> -->
<button type="button" class="btn btn-primary" tabindex="-1" role="button" onclick="window.open('generate-pdf.php', '_blank')">Launch Entire Show as a PDF</button>


</body>