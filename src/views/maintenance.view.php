<?php 
$title = "Under Maintenance";
ob_start();
include_once "src/pages/maintenance.php";
$content = ob_get_clean();
include 'src/components/layouts/mainLayout.php';
?>
