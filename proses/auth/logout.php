<?php
session_start();
require_once '../../koneksi.php';

// Clear remember me cookie if exists
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
    
    // Clear token from database if user is logged in
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        mysqli_query($koneksi, "UPDATE users SET remember_token = NULL WHERE id = $user_id");
    }
}

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

header('Location: ../../login.php');
exit;
