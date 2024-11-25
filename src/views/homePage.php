<?php 
$title = 'Homepage';
ob_start();
include "src/pages/homePage.php";
$content = ob_get_clean();
include 'src/components/layouts/mainLayout.php';
?>