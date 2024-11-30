<?php 
$title = 'Homepage';
ob_start();
include "src/pages/home/index.php";
$content = ob_get_clean();
include 'src/components/layouts/mainLayout.php';
?>