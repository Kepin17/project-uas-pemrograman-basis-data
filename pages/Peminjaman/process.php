<?php
require 'config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        mysqli_begin_transaction($conn);

        // Validate required fields
        $required_fields = ['kode_pinjam', 'id_anggota', 'id_petugas', 'tanggal_pinjam', 'estimasi_pinjam', 'id_buku'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        $kode_pinjam = $_POST['kode_pinjam'];
        $id_anggota = $_POST['id_anggota'];
        $id_petugas = $_POST['id_petugas'];
        $tanggal_pinjam = $_POST['tanggal_pinjam'];
        $estimasi_pinjam = $_POST['estimasi_pinjam'];
        $id_buku_array = $_POST['id_buku'];
        $jumlah_array = $_POST['jumlah'];
        $kondisi_array = $_POST['kondisi_pinjam'];

        // Insert into peminjaman table
        $query = "INSERT INTO peminjaman (kode_pinjam, id_anggota, id_petugas, tanggal_pinjam, estimasi_pinjam, status) 
                 VALUES (?, ?, ?, ?, ?, 'DIPINJAM')";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $kode_pinjam, $id_anggota, $id_petugas, $tanggal_pinjam, $estimasi_pinjam);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error inserting into peminjaman: " . mysqli_error($conn));
        }

        // Insert detail_peminjaman with total quantity
        foreach ($id_buku_array as $key => $id_buku) {
            $jumlah = $jumlah_array[$key];
            $kondisi = strtolower($kondisi_array[$key]); // Convert to lowercase to match enum values

            // Check stock availability
            $stock_query = "SELECT stok FROM buku WHERE id_buku = ?";
            $stock_stmt = mysqli_prepare($conn, $stock_query);
            mysqli_stmt_bind_param($stock_stmt, "s", $id_buku);
            mysqli_stmt_execute($stock_stmt);
            $stock_result = mysqli_stmt_get_result($stock_stmt);
            $current_stock = mysqli_fetch_assoc($stock_result)['stok'];

            if ($current_stock < $jumlah) {
                throw new Exception("Stok tidak mencukupi untuk buku dengan ID: $id_buku");
            }

            // Validate kondisi value
            if (!in_array($kondisi, ['bagus', 'rusak'])) {
                throw new Exception("Kondisi buku tidak valid: $kondisi");
            }

            // Insert single entry with total quantity
            $detail_query = "INSERT INTO detail_peminjaman (kode_pinjam, id_buku, kondisi_buku_pinjam, jumlah) 
                           VALUES (?, ?, ?, ?)";
            $detail_stmt = mysqli_prepare($conn, $detail_query);
            mysqli_stmt_bind_param($detail_stmt, "sssi", $kode_pinjam, $id_buku, $kondisi, $jumlah);
            
            if (!mysqli_stmt_execute($detail_stmt)) {
                throw new Exception("Error inserting into detail_peminjaman: " . mysqli_error($conn));
            }

            // Update book stock
            $update_query = "UPDATE buku SET 
                           stok = stok - ?,
                           status = CASE 
                               WHEN (stok - ?) <= 0 THEN 'DIPINJAM'
                               ELSE 'TERSEDIA'
                           END
                           WHERE id_buku = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, "iis", $jumlah, $jumlah, $id_buku);
            
            if (!mysqli_stmt_execute($update_stmt)) {
                throw new Exception("Error updating book stock: " . mysqli_error($conn));
            }
        }

        mysqli_commit($conn);
        header("Location: ../peminjaman?status=success&message=Peminjaman berhasil ditambahkan");
        exit();

    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: ../peminjaman?status=error&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../peminjaman");
    exit();
}
?>