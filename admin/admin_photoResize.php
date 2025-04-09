<?php
    $q = $pdo -> prepare("SELECT * FROM settings");
    $q -> execute();
    $settings = $q -> fetchAll(PDO::FETCH_ASSOC);
    $default_photo_width = $settings[7]["setting_value"];
    $default_photo_height = $settings[8]["setting_value"];

    $studPics = (scandir("../studPics"));
    unset($studPics[0]);
    unset($studPics[1]);
    
    if (isset($_POST["resize_photos"])) {

        foreach ($studPics as $studPic) {

            $studPicPath = "../studPics/$studPic";
            $studPicImageType = exif_imagetype($studPicPath);
            $studPicImageSize = getimagesize($studPicPath);

            if ($studPicImageSize != false) {
                if ($studPicImageType == IMAGETYPE_JPEG || $studPicImageType == IMAGETYPE_PNG) {

                    $studPicImageSizeWidth = $studPicImageSize[0];
                    $studPicImageSizeHeight = $studPicImageSize[1];

                    if ($studPicImageSizeWidth != $default_photo_width || $studPicImageSizeHeight != $default_photo_height) {

                        $dst_image = imagecreatetruecolor($default_photo_width, $default_photo_height);
                        $dst_x = 0;
                        $dst_y = 0;

                        $src_height = $studPicImageSizeHeight;
                        $r = $studPicImageSizeHeight / $default_photo_height; //ratio
                        $src_width = floor($default_photo_width * $r);
  
                        $src_x = floor(($studPicImageSizeWidth - $src_width) / 2);

                        
                        $src_y = 0;

                        $dst_width = $default_photo_width;
                        $dst_height = $default_photo_height;

                        if ($studPicImageType == IMAGETYPE_JPEG) {
                            $studPicPathIdentifier = imagecreatefromjpeg($studPicPath);
                            imagecopyresampled($dst_image, $studPicPathIdentifier, $dst_x, $dst_y, $src_x, $src_y, $dst_width, $dst_height, $src_width, $src_height);
                            unlink($studPicPath);
                            imagejpeg($dst_image, $studPicPath);
                        }
                        else if ($studPicImageType == IMAGETYPE_PNG) {
                            $studPicPathIdentifier = imagecreatefrompng($studPicPath);
                            imagecopyresampled($dst_image, $studPicPathIdentifier, $dst_x, $dst_y, $src_x, $src_y, $dst_width, $dst_height, $src_width, $src_height);
                            unlink($studPicPath);
                            imagepng($dst_image, $studPicPath);
                        }
                     
                    }
                
                }

            }
        }

        echo "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                Photos sucessfully resized to $default_photo_width x $default_photo_height                
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
        ";
    }
?>

<h1>Photo Resize</h1>
<?php 
    echo "Photos will be resized to ".$default_photo_width." x ".$default_photo_height." by default.";

    $total_studPics = count($studPics);
    $resize_studPics = 0;
    foreach ($studPics as $studPic) {
        $studPicPath = "../studPics/$studPic";
        $studPicImageSize = getimagesize($studPicPath);
        if ($studPicImageSize != false) {
            $studPicImageSizeWidth = $studPicImageSize[0];
            $studPicImageSizeHeight = $studPicImageSize[1];
            if ($studPicImageSizeWidth != $default_photo_width || $studPicImageSizeHeight != $default_photo_height) {
                $resize_studPics++;
            }
        }     
    }

    $percent_resize = floor(($resize_studPics / $total_studPics) * 100);
    $percent_default = 100 - $percent_resize;
    $percent_resize = $percent_resize . "%";
    $percent_default = $percent_default . "%";

?>

<div class="progress mt-2" style="height: 30px">
    <div class="progress-bar bg-success" <?php echo "style=\"width:$percent_default\""?>>
        <?php echo "$default_photo_width x $default_photo_height ($percent_default)"?>

    </div>
    <div class="progress-bar bg-danger" <?php echo "style=\"width:$percent_resize\""?>>
        <?php echo "Resize ($percent_resize)"?>
    </div>
</div>

<div class="mt-2 mb-2">
    <form action="" method="post">
        <input type="hidden" name="resize_photos">
        <input class="btn btn-primary" type="submit" value="Resize photos">
    </form>
</div>


<?php

    echo "<div class=\"row ms-1 mb-2\">";
    echo "<div class=\"col-2\"><b>Name</b></div>";
    echo "<div class=\"col-1\"><b>Width</b></div>";
    echo "<div class=\"col-1\"><b>Height</b></div>";
    echo "<div class=\"col-1\"><b>Path</b></div>";
    echo "</div>";

    $studPics = (scandir("../studPics"));
    unset($studPics[0]);
    unset($studPics[1]);

    array_multisort($studPics, SORT_ASC, SORT_NUMERIC);

    echo "<ul class=\"list-group\">";

    foreach ($studPics as $studPic) {

        $studPicPath = "../studPics/$studPic";
        $studPicImageSize = getimagesize($studPicPath);

        if ($studPicImageSize != false) {

            $studPicImageSizeWidth = $studPicImageSize[0];
            $studPicImageSizeHeight = $studPicImageSize[1];

            if ($studPicImageSizeWidth != $default_photo_width || $studPicImageSizeHeight != $default_photo_height) {
                echo "<li class=\"list-group-item bg-danger\">";
            }
            else {
                echo "<li class=\"list-group-item\">";
            }
            echo "<div class=\"row\">";
            echo "<div class=\"col-2\"><a href=\"$studPicPath\" target=\"_blank\">$studPic</a></div>";
            echo "<div class=\"col-1\">$studPicImageSizeWidth</div>";
            echo "<div class=\"col-1\">$studPicImageSizeHeight</div>";
            echo "<div class=\"col-2\">$studPicPath</div>";
            echo "</div>";
            echo "</li>";

        }
              
    }
    echo "</ul>";


?>