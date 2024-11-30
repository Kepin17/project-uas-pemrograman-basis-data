<?php 
$title = 'Page Not Found';
ob_start();
include_once "src/pages/error/404.php";
$content = ob_get_clean();
include 'src/components/layouts/mainLayout.php';
?>

