<?php
$title = 'Homepage';
ob_start();
include 'Pages/homepage.php';
$content = ob_get_clean();
include 'components/layouts/mainLayout.php';
?>
