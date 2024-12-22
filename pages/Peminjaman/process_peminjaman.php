<?php
session_start();
require_once(__DIR__ . '/../../config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $kode_pinjam = $_POST['kode_pinjam'];
        $id_anggota = $_POST['id_anggota'];
        $tanggal_pinjam = $_POST['tanggal_pinjam'];
        $estimasi_pinjam = $_POST['estimasi_pinjam'];
        $id_petugas = $_SESSION['id_']; // Assuming you have user session
        $status = 'DIPINJAM';
        
        // Start transaction
        mysqli_begin_transaction($conn);
        
        // Insert into peminjaman table
        $query = "INSERT INTO peminjaman (kode_pinjam, id_anggota, id_petugas, tanggal_pinjam, estimasi_pinjam, status) 
                 VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "siisss", $kode_pinjam, $id_anggota, $id_petugas, $tanggal_pinjam, $estimasi_pinjam, $status);
        mysqli_stmt_execute($stmt);
        
        // Insert book details
        if (isset($_POST['books']) && is_array($_POST['books'])) {
            $detail_query = "INSERT INTO detail_peminjaman (kode_pinjam, id_buku, jumlah) VALUES (?, ?, ?)";
            $detail_stmt = mysqli_prepare($conn, $detail_query);
            
            // Update book stock
            $update_stock = "UPDATE buku SET stok = stok - ? WHERE id_buku = ?";
            $stock_stmt = mysqli_prepare($conn, $update_stock);
            
            foreach ($_POST['books'] as $id_buku => $qty) {
                // Insert detail peminjaman
                mysqli_stmt_bind_param($detail_stmt, "sii", $kode_pinjam, $id_buku, $qty);
                mysqli_stmt_execute($detail_stmt);
                
                // Update stock
                mysqli_stmt_bind_param($stock_stmt, "ii", $qty, $id_buku);
                mysqli_stmt_execute($stock_stmt);
            }
        }
        
        // Commit transaction
        mysqli_commit($conn);
        $_SESSION['success'] = "Peminjaman berhasil ditambahkan!";
        
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($conn);
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    }
    
    // Redirect back
    header('Location: ' . BASE_URL . '/peminjaman');
    exit;
}
