<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/google-auth/api.php');
    google_logout();
    header('Location: ./');
?>