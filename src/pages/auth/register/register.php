<?php 
ob_start();
include_once "src/pages/auth/register/registerForm.php";
$formContent = ob_get_clean();
include "src/components/layouts/authLayout.php";
?>