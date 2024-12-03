<?php 
$title = "Books Collection";
ob_start();
include_once "src/pages/book/index.php";
$content = ob_get_clean();
include 'src/components/layouts/mainLayout.php';
?>
