<?php 
$title = "category Collection";
ob_start();
include_once "src/pages/category-book/index.php";
$content = ob_get_clean();
include 'src/components/layouts/mainLayout.php';
?>
