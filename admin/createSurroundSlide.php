
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
    padding: 70px 0;
  }
</style> 
</head>
<body>
  <h3>Create and Style a Surrounding Slide Below</h3>
  <!-- <div class="box" id="displayBox"></div> -->
  <a href="https://wcss.emmell.org/gradD/admin/admin_styleNav.php?page=admin_showSurroundSlides.php">Go back to surround slides</a>
  <div style="display: flex; justify-content: center;">
  <form method="POST" id="myForm" action="">
    <textarea name="editContent" id="editContent" style="width: 1200px; height: 650px;"></textarea>
    <button class="btn btn-primary col text-center" name="save" type="submit">CREATE</button>
  </form>
</div>

<?php 
require_once("../database.php");
if (isset($_POST['save'])){
  $editContent = $_POST['editContent']; 
  $cleanText = strip_tags($editContent); 
  echo $editContent;

  $q = $pdo->prepare("SELECT MAX(surround_id) as max_id FROM surroundingSlides");
  $q->execute();
  $result = $q->fetch(PDO::FETCH_ASSOC);
  $newSlideId = $result['max_id'] + 1;
  $q = $pdo->prepare("INSERT INTO surroundingSlides (surround_id, surround_name, surround_html, surround_active) VALUES (:newSlideId, :cleanText, :editContent, '0')");
  $q->bindParam(":cleanText", $cleanText);
  $q->bindParam(":newSlideId", $newSlideId);
  $q->bindParam(":editContent", $editContent);
  $q->execute();
}
?> 

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




