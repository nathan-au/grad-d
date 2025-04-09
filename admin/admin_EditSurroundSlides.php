<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.tiny.cloud/1/t03uf5ormjh22cia4fb49getjm982kfb7ddhy8izfr6o9zpf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <style>
  .box {
    border: 1px solid black;
    width: 1000px;
    height: 500px;
    margin: auto;
  }
</style> 
</head>
<body>
<?php
  require_once("../database.php");
  if (isset($_POST['save'])){
      $surroundId = $_GET['surroundId']; 
      $editContent = $_POST['editContent']; 
      $cleanText = strip_tags($editContent); 
      $q = $pdo->prepare("UPDATE `surroundingSlides` SET `surround_html`= :editContent, `surround_name`= :cleanText WHERE `surround_id` = :surroundId");
      $q->bindParam(":editContent", $editContent);
      $q->bindParam(":cleanText", $cleanText);
      $q->bindParam(":surroundId", $surroundId);
      $q->execute();
    }
    ?> 
    
<a href="https://wcss.emmell.org/gradD/admin/admin_styleNav.php?page=admin_showSurroundSlides.php">Go back to surround slides</a>
  
<form method="POST" id="myForm" action="">
  <?php
    require_once("../database.php");
    $surroundId = $_GET['surroundId'];

    $q = $pdo->prepare("SELECT `surround_html` FROM `surroundingSlides` WHERE `surround_id` = :surroundId");
    $q->bindParam(":surroundId", $surroundId);
    $q->execute();
    $surroundingSlide = $q->fetch(PDO::FETCH_ASSOC);

    $editContent = $surroundingSlide['surround_html'];
    ?>
  <div style="display: flex; justify-content: center;">
    <textarea name="editContent" id="editContent" style="width: 1200px; height: 650px;"><?php echo $editContent?> </textarea>
  </div>
  <button class="btn btn-primary" name="save" type="submit">SAVE</button>
  </form>

  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      setup: function (editor) {
        editor.on('input', function () {
          var content = editor.getContent();
          document.getElementById('displayBox').innerHTML = content;
        });
      }
    });
  </script>
</body>
</html>


