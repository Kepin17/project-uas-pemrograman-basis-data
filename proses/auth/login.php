<?php
session_start();
require 'connection.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : '';

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['name'] = $data['name'];
            
            // Set remember me cookie if checked
            if ($remember == 'on') {
                $token = bin2hex(random_bytes(32)); // Generate secure token
                setcookie('remember_token', $token, time() + (14 * 24 * 60 * 60), '/'); // 14 days
                
                // Store token in database
                $user_id = $data['id'];
                mysqli_query($koneksi, "UPDATE users SET remember_token = '$token' WHERE id = $user_id");
            }

            header('Location: ../../index.php');
            exit;
        }
    }
    
    $_SESSION['error'] = 'Email atau password salah';
    header('Location: ../../login.php');
    exit;
}
