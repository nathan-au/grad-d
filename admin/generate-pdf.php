<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once("../database.php");
require_once("../mainFunctions.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/google-auth/api.php');
verifyLogin("admin");

use Mpdf\Mpdf;

$mpdf = new \Mpdf\Mpdf(['orientation'=>'L']);

$query = $pdo->prepare("SELECT * FROM students ORDER BY stud_lname");
$query->execute();
$students = $query->fetchALL(PDO::FETCH_ASSOC);


$mpdf->AddPageByArray(['orientation' => 'L']);

foreach ($students as $s){
    $id = $s['stud_id'];
    ob_start();
    include("../admin/admin_sendPdf.php");
    $html = ob_get_clean();
    $mpdf->WriteHTML($html);
    $mpdf-> AddPage();
}

$mpdf->Output();


?>
