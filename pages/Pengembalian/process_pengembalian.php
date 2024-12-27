<?php
require "config/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Start transaction
        $conn->begin_transaction();

        $kode_pinjam = $_POST['peminjaman_id'];
        $kondisi_buku = $_POST['kondisi_buku'];
        
        // Calculate denda based on kondisi
        $denda_kondisi = [
            'bagus' => 0,
            'rusak' => 100000,
            'hilang' => 500000
        ];
        
        // Constants
        $DENDA_PER_HARI = 5000;
        
        // Get peminjaman details to calculate late fee
        $query_pinjam = "SELECT DATEDIFF(CURRENT_DATE, estimasi_pinjam) as keterlambatan 
                         FROM peminjaman WHERE kode_pinjam = ?";
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

        // Insert into pengembalian table with denda
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
            
            // Update book stock
            $update_stock = "UPDATE buku b 
                            JOIN peminjaman p ON b.id_buku = p.id_buku 
                            SET b.stok = b.stok + 1,
                                b.status = CASE 
                                    WHEN b.stok + 1 > 0 THEN 'TERSEDIA'
                                    ELSE 'DIPINJAM'
                                END
                            WHERE p.kode_pinjam = ?";
            $stmt = $conn->prepare($update_stock);
            $stmt->bind_param("s", $kode_pinjam);
            $stmt->execute();
            
            // Commit transaction
            $conn->commit();
            
            $response = [
                'status' => 'success',
                'message' => 'Pengembalian berhasil diproses',
                'data' => [
                    'kode_pengembalian' => $kode_pengembalian,
                    'total_denda' => $total_denda
                ]
            ];
        } else {
            throw new Exception("Error executing query");
        }
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        
        $response = [
            'status' => 'error',
            'message' => 'Gagal memproses pengembalian: ' . $e->getMessage()
        ];
    }
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
    
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
    exit;
}
?>
