<?php
session_start();
require_once(__DIR__ . '/../../config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_pinjam = $_POST['kode_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $catatan = $_POST['catatan'];
    $book_ids = $_POST['book_ids'];
    $quantities = $_POST['quantities'];
    $conditions = $_POST['conditions'];

    try {
        // Start transaction
        mysqli_begin_transaction($conn);

        // Update peminjaman status
        $update_peminjaman = "UPDATE peminjaman 
                            SET status = 'DIKEMBALIKAN', 
                                tanggal_kembali = ?, 
                                catatan_pengembalian = ? 
                            WHERE kode_pinjam = ?";
        $stmt = mysqli_prepare($conn, $update_peminjaman);
        mysqli_stmt_bind_param($stmt, "sss", $tanggal_kembali, $catatan, $kode_pinjam);
        mysqli_stmt_execute($stmt);

        // Process each returned book
        foreach ($book_ids as $index => $book_id) {
            $condition = $conditions[$index];
            $quantity = $quantities[$index];

            // Update book stock based on condition
            if ($condition === 'BAIK') {
                // If book is in good condition, restore stock
                $update_stock = "UPDATE buku SET stok = stok + ? WHERE id_buku = ?";
                $stmt = mysqli_prepare($conn, $update_stock);
                mysqli_stmt_bind_param($stmt, "is", $quantity, $book_id);
                mysqli_stmt_execute($stmt);
            }

            // Record book condition in detail_pengembalian
            $insert_detail = "INSERT INTO detail_pengembalian 
                            (kode_pinjam, id_buku, kondisi_kembali, qty) 
                            VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_detail);
            mysqli_stmt_bind_param($stmt, "sssi", $kode_pinjam, $book_id, $condition, $quantity);
            mysqli_stmt_execute($stmt);
        }

        // Commit transaction
        mysqli_commit($conn);

        $_SESSION['success'] = "Pengembalian buku berhasil diproses!";
        header("Location: index.php");
        exit();

    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($conn);
        
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Method not allowed!";
    header("Location: index.php");
    exit();
}
?>
