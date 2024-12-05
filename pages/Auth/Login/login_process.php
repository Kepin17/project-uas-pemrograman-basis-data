<?php
session_start();
require_once '../../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // For demonstration (replace with actual database authentication)
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;
        $_SESSION['user_role'] = 'admin';
        
        // Redirect to dashboard
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    } else {
        // Set error message
        $_SESSION['login_error'] = 'Username atau password salah';
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
} else {
    // If not POST request, redirect to login page
    header('Location: ' . BASE_URL . '/login');
    exit;
}
?>
