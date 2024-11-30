<?php 
$title = "Register";
ob_start();
include_once "src/pages/registerPage.php";
$content = ob_get_clean();
include 'src/components/layouts/mainLayout.php';
?>

