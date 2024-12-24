<?php
require 'config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_peminjaman = $_POST['kode_pinjam'];
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tgl_pinjam = $_POST['tanggal_pinjam'];
    $tgl_kembali = $_POST['estimasi_pinjam'];
    $id_petugas = $_POST['id_petugas'];
    $status = 'Dipinjam'; // Default status when borrowing

    // Prepare SQL query
    $query = "INSERT INTO peminjaman (kode_pinjam, id_anggota, id_buku, id_petugas, tanggal_pinjam, estimasi_pinjam, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare and bind parameters - changed last parameter from i to s for status
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssss", $id_peminjaman, $id_anggota, $id_buku, $id_petugas, $tgl_pinjam, $tgl_kembali, $status);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        // Update buku stock
        $update_query = "UPDATE buku SET stok = stok - 1 WHERE id_buku = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "s", $id_buku);
        mysqli_stmt_execute($update_stmt);
        
        // Success
        header("Location: ../peminjaman?status=success&message=Peminjaman berhasil ditambahkan");
        exit();
    } else {
        // Error
        header("Location: ../peminjaman?status=error&message=Gagal menambahkan peminjaman");
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    // If not POST request, redirect to index
    header("Location: ../peminjaman");
    exit();
}
?>