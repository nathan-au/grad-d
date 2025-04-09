<?php
    require("stud_functions.php");
    verifyLogin("student");
    
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php echo(func_checkOpen());?>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        
        <!-- External Libraries for JAVASCRIPT -->
        <script src="https://code.jquery.com/jquery-3.6.1.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
        <script src="https://cdn.tiny.cloud/1/t03uf5ormjh22cia4fb49getjm982kfb7ddhy8izfr6o9zpf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        
        <!--Page Title-->
        <title>Grad Slide Show</title>
        <link rel="icon" href="../images/wcss_concept_white.png">
        

        <style>
            /* FONTS */
            @font-face {
                font-family: font_sweet_romance;
                src: url(../images/sweet_romance.ttf);
            }
            @font-face {
                font-family: font_montserrat_light;
                src: url(../images/montserrat_light.ttf);
            }
            @font-face {
                font-family: font_montserrat_bold;
                src: url(../images/montserrat_bold.ttf);
            }
            @font-face {
                font-family: font_montserrat_regular;
                src: url(../images/montserrat_regular.ttf);
            }
            
            /* SMOOTH SCROLL ANIMATION */
            @media screen and (prefers-reduced-motion: reduce) {
                html {
                    scroll-behavior: auto;
                }
            }

            /* STACKING STYLING */
            html,body {
                height:100%;
                max-width: 100%;
                overflow-x: hidden; /*DISABLE HORIZONTAL SCROLL*/
                scroll-behavior: smooth; /*PART OF SMOOTH SCROLL*/
            }
            .div_parent {
                display: block;
                justify-content: space-between;
            }
            .div_child {
                height:100vh;
                width:100vw;
                position:relative;
                overflow-x: hidden;
            }
        </style>
    </head>
    <body>
        <!--TOASTS(NOTIFICATIONS)-->
        <div style="position: fixed; top: 50px; right: 10px; z-index: 10;">
            <div id="toast_submit_success" class="toast">
                <div class="toast-header">
                    Grad Manager
                </div>
                <div class="toast-body">
                    Data saved successfully! Take a peak at the slideshow preview.
                </div>
            </div>
            <div id="toast_report_success" class="toast">
                <div class="toast-header">
                    Grad Manager
                </div>
                <div class="toast-body">
                    Report was sent successfully!
                </div>
            </div>
        </div>
        
        <!--FIXED BUTTONS-->
        <div style="position:fixed; top:5px; right:5px; z-index:3">
            <button type="button" class="btn btn-warning" onclick="showModal()">Help/Report</button>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
    
        <!--INCLUDE DIFFERENT PAGES-->
        <div class="div_parent">
            <?php include "stud_welcome.php"?>
            <?php include "stud_instructions.php"?>
            <?php include "stud_editInfo.php"?>
            <div id="slideshowFrame" class="div_child" style="height: 100%; overflow: hidden;"></div>
        </div>
        <?php include "stud_reportModal.php"?>
        
        <!--INITIALIZE SLIDESHOW PREVIEW-->
        <script>
            $("#slideshowFrame").load("stud_showPresent.php", function(responseTxt, statusTxt, xhr){
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText + ". Contact an admin using the report feature.");
            });
        </script>
        
        <?php //include "stud_preview.php"?>
    </body>
</html>