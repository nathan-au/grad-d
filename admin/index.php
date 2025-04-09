
<?php
    require_once("../database.php");
    require_once("../mainFunctions.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/google-auth/api.php');
    verifyLogin("admin");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="icon" href="../images/wcss_concept_white.png" type="image/icon type">

        <?php
            if (isset($_GET["page"])) {

                $page = $_GET["page"];
                $page = substr($page, 6);
                $page = substr($page, 0, -4);
                $page = ucfirst($page);

                echo "<title>WCSS Grad Admin - ".$page."</title>";
            }
        ?>
        
    </head>
    <body>

        <div class="container ">
            <nav class="navbar navbar-expand-lg border border-dark rounded border-3 mt-2 ps-3 bg-light mb-3">
                <span class="navbar-brand"><a class="nav-link" href="./"><b>WCSS GRAD SYSTEM - ADMIN</b></a></span>
                <ul class="navbar-nav">


                    <li class="nav-item me-2 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Students</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_studentList.php">Students List</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_createStudents.php">Create Students</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item me-2 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Slideshow</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_slideOptions.php">Slide Options</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_showSurroundSlides.php">Surrounding Slides</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item me-2 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Photos</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_photos.php">Photos</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_photoMissing.php&sort=Name">Missing Photos</a>
                            </li>                            
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_photoResize.php">Resize Photos</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="?page=admin_preCachePics.php">Photos Cache</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="?page=admin_awards.php">Awards</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="?page=admin_config.php">Config</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="?page=admin_logs.php">Logs</a>
                    </li>

                    <li class="nav-item me-2 dropdown position-absolute end-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo getUserInfo("admin_email"); ?></a>
                        <ul class="dropdown-menu">
                            <li class="nav-item me-2">
                                <a class="nav-link text-danger" href="../logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
    
            <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                }
                else {
                    $page = "admin_dashboard.php";
                }
                include($page);
            ?>                        
                    

        </div>
    
        <script src="https://code.jquery.com/jquery-3.6.1.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    </body>
</html>