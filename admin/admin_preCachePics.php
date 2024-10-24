
<?php 
$photos = scandir("../studPics");
foreach ($photos as $p){
  if ($p != "." && $p != ".."){
    echo "<img src = '../studPics/".$p."' alt='".$p."' height = '100'>"; 
  }
}
?>