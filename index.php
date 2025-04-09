<?php
    require("database.php");

    if (isset($_POST["send_msg"])) {

        $msg_email = $_POST["msg_email"];
        $msg_text = $_POST["msg_text"];

        if (strpos($msg_email, '@')) {
            $q = $pdo -> prepare("INSERT INTO messages (msg_email, msg_text, msg_stud_id) VALUES (:msg_email, :msg_text, -1)");
            $q -> bindParam("msg_email", $msg_email);
            $q -> bindParam("msg_text", $msg_text);
            $q -> execute();
        }

    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <title>WCSS Grad Landing Page</title>
        <link rel="icon" href="./images/wcss_concept_white.png" type="image/icon type">

        <style>
            .btn, .alert, .modal-content, .form-control {
                border-radius: 0;
            }

            div.style_backgroundDiv{
                background-color: gray ;
                opacity: 0.7;
                height:100%;
                width:100%;
                right:0;
                top:0;
                position: absolute;
                z-index: -1;
            }
            img.style_backgroundImg{
                height:100%;
                width:100%;
                right:0;
                top:0;
                position: absolute;
                z-index: -2;
            }
        </style>
    </head>
    <body> 
       
        <?php
            $q = $pdo -> prepare("SELECT * FROM settings");
            $q -> execute();
            $settings = $q -> fetchAll(PDO::FETCH_ASSOC);
            $due_date = $settings[0]['setting_value'];
            $display_info = $settings[5]['setting_value'];
            $login_messages = $settings[6]['setting_value']
        ?>

        <div class = "style_backgroundDiv"></div>
        <img class = "style_backgroundImg" src="images/school_background2.png"> 

        <div class="container mt-5">
            <div class="row mt-5">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-8 border border-dark bg-dark">
                            <div class="text-center mt-3">
                                <img src="images/wcss_concept_white.png" alt="" width="50%" height="auto">
                            </div>
                            <div class="text-center mb-3 text-light">
                                <h1><b>West Carleton Grad System</b></h1>
                            </div>
                            <div class="text-center mb-3">
                                <a class="btn btn-primary text-light" href="./login.php">Login with Google</a>
                                <?php
                                    if ($login_messages == "on") {
                                        echo "<button type=\"button\" class=\"btn btn-secondary\" data-bs-toggle=\"modal\" data-bs-target=\"#message_form_modal\">Send a message</button>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-4 border border-dark border-5"> 
                            <div class="alert alert-danger mb-0 mt-3" role="alert">
                                Reminder: All student information submissions are due <?php echo $due_date;?>
                            </div>
                            <div class="p-3 text-light" id="display_info">
                                <p class="lead mb-0"><?php echo $display_info;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="message_form_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Send a Message</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="msg_email" id="msg_email" placeholder="msg_email" required>
                                <label for="msg_email">Your email</label>
                            </div>
                            <div class="form-floating">
                                <input class="form-control" type="text" name="msg_text" id="msg_text" placeholder="msg_text" maxlength="100" required>
                                <label for="msg_text">Message</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <input type="hidden" name="send_msg">
                            <input class="btn btn-primary" type="submit" value="Send message">
                        </div>
                    </form>
                </div>
            </div>
        </div>
  
        <script src="https://code.jquery.com/jquery-3.6.1.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.js" crossorigin="anonymous"></script>    

    </body>
</html>

