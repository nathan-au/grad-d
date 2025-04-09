<style>
    div.style_name_banner{
        background:rgb(0, 1, 80);
        top:2%;
        height:21%;
        width:100%;
        left:0;
        position:absolute;
    }
    div.style_test{
        top:25%;
        height:75%;
        width:100%;
        left:0;
        position:absolute;
    }
    h1.style_welcome_name{
        position:absolute;
        color:white;
        font-family: font_montserrat_bold;
        font-size: 3.25vw;
        text-align:center;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
    }
    h1.style_instruct_head{
        font-family: font_montserrat_bold;
        font-size: 2.5vw;
    }
    p.style_instruct_body{
        font-family: font_montserrat_regular;
        font-size: 1.5vw;
        line-height:1.25em;
    }
    .style_warning{
        color:red;
    }
    
    img.style_image_preview{
        transform-origin: center;
        transform: translate(-50%, -50%);
        border-style: outset;
        border-width: 1vh;
        border-color: rgb(225, 225, 225);
        height: 40%;
        width: auto;
        position:absolute;
    }
</style>

<div class="div_child">
    <div id="href_welcome_banner" class="style_name_banner"> 
        <h1 id="text_congrats_name"class="style_welcome_name"></h1> 
    </div>
    <div class="style_test">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-4" style="position:relative;height:75vh;">
                <img id="image_grade9" class="style_image_preview" style="top:25%;left:25%;z-index:1;">
                <img id="image_grade10" class="style_image_preview" style="top:25%;left:75%;z-index:1;">
                <img id="image_grade11" class="style_image_preview" style="top:75%;left:25%;z-index:1;">
                <img id="image_grade12" class="style_image_preview" style="top:75%;left:75%;z-index:1;">
                <img id="image_grade13" class="style_image_preview" style="top:50%;left:50%;z-index:2;">
            </div>
            <div class="col-6" style="position:relative;height:75vh;margin:auto;">
                <h1 class="style_instruct_head">It's finally the end of High School!<h1>
                <p class="style_instruct_body">
                    Now's your chance to impress your peers at grad. Make sure you complete the following steps to seal the deal! Rememinder that submissions closes <b class="style_warning"><?php echo(func_getSettingsInfo("due_date"));?></b>.<br>
                    <br>1.  Check your photos! If one of them is missing and you would like to upload it, use the report feature to send a message and we'll get back to you ASAP.
                    <br>2.  Fill out the following fields beneath. They each have guidelines to help you out. Try your best to not leave the memorable moments section blank!
                    <br>3.  Take a peak at your slide! <i class="style_warning">Your awards may not <b>all</b> be there as guidance will be uploading them at a later date.</i>
                    <br>4.  Check your Google Classroom for any further instructions for the ceremony.
                    <br>5.  🎉 YOU'RE DONE! 🎉 HAVE A GREAT SUMMER!
                </p>
            </div>
        </div>
    </div>
</div>

<?php //LINKING ARRAY OF PICTURES
    $studID = getUserInfo('stud_id');
    $studPics = [];
    for ($i = 9; $i <= 13; $i++) {
        $imgUrl = "../studPics/".$i."_".$studID.".jpg";
        if (file_exists($imgUrl)) {
            $studPics[$i] = $imgUrl;
        }
    }
?>

<script>
    var stud_firstName = <?php echo json_encode(getUserInfo('stud_fname'));?>; //WELCOME MESSAGE WITH NAME
    document.getElementById('text_congrats_name').innerHTML = ("CONGRATS "+stud_firstName.toUpperCase()+"!");

    var pictures = (<?php echo json_encode($studPics)?>); //IMAGE SOURCING
    for(var i=9;i<=13;i++) {
        if (i in pictures){
            document.getElementById("image_grade"+i).src = pictures[i];
        } else {
            document.getElementById("image_grade"+i).src = "../images/missing_photo.png";
        }
    }
</script>

