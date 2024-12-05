<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page
header('Location: ' . BASE_URL . '/login');
exit;
?>
