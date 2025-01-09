<?php
require "config/connection.php";

// Define the correct base URL
define('BASE_URL', '/project-uas/project-uas-pemrograman-basis-data');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Start transaction
        $conn->begin_transaction();

        $kode_pinjam = $_POST['peminjaman_id'];
        $kondisi_buku = $_POST['kondisi_buku'];
        
        // Get all books associated with this peminjaman
        $query_books = "SELECT dp.id_buku 
                       FROM detail_peminjaman dp 
                       WHERE dp.kode_pinjam = ?";
        $stmt = $conn->prepare($query_books);
        $stmt->bind_param("s", $kode_pinjam);
        $stmt->execute();
        $books_result = $stmt->get_result();
        $book_ids = [];
        while ($row = $books_result->fetch_assoc()) {
            $book_ids[] = $row['id_buku'];
        }
        
        // Calculate denda based on kondisi
        $denda_kondisi = [
            'bagus' => 0,
            'rusak' => 100000,
            'hilang' => 500000
        ];
        
        // Constants
        $DENDA_PER_HARI = 5000;
        
        // Get peminjaman details and book IDs
        $query_pinjam = "SELECT p.*, GROUP_CONCAT(dp.id_buku) as book_ids,
                         DATEDIFF(CURRENT_DATE, p.estimasi_pinjam) as keterlambatan 
                         FROM peminjaman p
                         LEFT JOIN detail_peminjaman dp ON p.kode_pinjam = dp.kode_pinjam
                         WHERE p.kode_pinjam = ?
                         GROUP BY p.kode_pinjam";
        $stmt = $conn->prepare($query_pinjam);
        $stmt->bind_param("s", $kode_pinjam);
        $stmt->execute();
        $pinjam_result = $stmt->get_result()->fetch_assoc();
        
        // Calculate total denda
        $hari_terlambat = max(0, $pinjam_result['keterlambatan']);
        $denda_terlambat = $hari_terlambat * $DENDA_PER_HARI;
        $total_denda = $denda_terlambat + $denda_kondisi[$kondisi_buku];

        // Generate new kode_pengembalian
        $query = "SELECT MAX(CAST(SUBSTRING(kode_pengembalian, 3) AS SIGNED)) as max_id FROM pengembalian";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $next_id = ($row['max_id'] ?? 0) + 1;
        $kode_pengembalian = 'PB' . str_pad($next_id, 3, '0', STR_PAD_LEFT);

        // Insert into pengembalian table
        $query = "INSERT INTO pengembalian (
            kode_pengembalian, 
            tanggal_pengembalian,
            kode_pinjam,
            kondisi_buku,
            denda
        ) VALUES (?, NOW(), ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssd", 
            $kode_pengembalian,
            $kode_pinjam,
            $kondisi_buku,
            $total_denda
        );
        
        if ($stmt->execute()) {
            // Update peminjaman status
            $update_query = "UPDATE peminjaman SET status = 'DIKEMBALIKAN' WHERE kode_pinjam = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("s", $kode_pinjam);
            $stmt->execute();
            
            // Update each book's stock
            foreach ($book_ids as $id_buku) {
                $update_stock = "UPDATE buku 
                               SET stok = stok + 1,
                                   status = CASE 
                                       WHEN stok + 1 > 0 THEN 'TERSEDIA'
                                       ELSE 'DIPINJAM'
                                   END
                               WHERE id_buku = ?";
                $stmt = $conn->prepare($update_stock);
                $stmt->bind_param("s", $id_buku);
                $stmt->execute();
            }
            
            // Commit transaction
            $conn->commit();
            
            // Fix redirect URL
            header('Location: ../returning?page=returning&status=success&message=Pengembalian berhasil diproses');
            exit;
        } else {
            throw new Exception("Error executing query");
        }
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        
        // Fix redirect URL for error
        header('Location: ../returning?page=returning&status=error&message=' . urlencode($e->getMessage()));
        exit;
    }
} else {
    // Fix redirect URL for invalid method
    header('Location: ../returning?page=returning&status=error&message=Invalid request method');
    exit;
}
?>
