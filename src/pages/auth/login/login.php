<?php
ob_start();
include 'loginForm.php';
$formContent = ob_get_clean();
include_once 'src/components/layouts/authLayout.php';
?>
