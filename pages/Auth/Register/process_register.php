<?php
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../config/config.php';

// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_anggota = $_POST['nama_anggota'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Password tidak cocok";
        header('Location: ' . BASE_URL . '/register');
        exit();
    }

    // Check if email already exists
    $check_query = "SELECT * FROM anggota WHERE email = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param('s', $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = "Email sudah terdaftar";
        header('Location: ' . BASE_URL . '/register');
        exit();
    }

    // Generate nomor anggota
    $query = "SELECT id_anggota FROM anggota ORDER BY id_anggota DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $last_id = $result->fetch_assoc()['id_anggota'];
        $number = intval(substr($last_id, 2)) + 1;
    } else {
        $number = 1;
    }
    
    $nomor_anggota = sprintf("AG%03d", $number);
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new member
    $insert_query = "INSERT INTO anggota (id_anggota, nama_anggota, alamat, nomor_telp, email, password) 
                     VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param('ssssss', $nomor_anggota, $nama_anggota, $alamat, $no_telp, $email, $hashed_password );

    if ($insert_stmt->execute()) {
        $_SESSION['login_success'] = "Pendaftaran berhasil! Silahkan login.";
        header('Location: ' . BASE_URL . '/login');
        exit();
    } else {
        $_SESSION['register_error'] = "Pendaftaran gagal. Silahkan coba lagi.";
        header('Location: ' . BASE_URL . '/register');
        exit();
    }
}

header('Location: ' . BASE_URL . '/register');
exit();
