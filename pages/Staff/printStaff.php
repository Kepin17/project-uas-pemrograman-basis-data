<?php
require "config/connection.php";

// Check for proper session and access rights
if (!isset($_SESSION['id_jabatan']) || $_SESSION['id_jabatan'] !== 'JB001') {
    die('Unauthorized access');
}

// Get staff data
$query = "SELECT p.*, j.nama_jabatan FROM petugas p 
          LEFT JOIN jabatan j ON p.id_jabatan = j.id_jabatan 
          ORDER BY p.nama_petugas";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Petugas Perpustakaan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .print-header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="print-header">
        <h2>Daftar Petugas Perpustakaan</h2>
        <p>Tanggal: <?php echo date('d-m-Y'); ?></p>
    </div>

    <table>
        <tr>
            <th>Nama Petugas</th>
            <th>Email</th>
            <th>No. Telepon</th>
            <th>Jabatan</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['nama_petugas']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['nomor_telp']; ?></td>
            <td><?php echo $row['nama_jabatan']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <button class="no-print" onclick="window.print()">Cetak</button>
</body>
</html>
