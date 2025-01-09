<?php
require 'config/connection.php';

// Check for proper session
if (!isset($_SESSION['id_jabatan'])) {
    die('Unauthorized access');
}

// Get dashboard statistics
$queryBuku = "SELECT COUNT(*) as total_buku FROM buku";
$queryAnggota = "SELECT COUNT(*) as total_anggota FROM anggota";
$queryPeminjaman = "SELECT COUNT(*) as total_peminjaman FROM peminjaman";
$queryPetugas = "SELECT COUNT(*) as total_petugas FROM petugas";

$resultBuku = $conn->query($queryBuku)->fetch_assoc();
$resultAnggota = $conn->query($queryAnggota)->fetch_assoc();
$resultPeminjaman = $conn->query($queryPeminjaman)->fetch_assoc();
$resultPetugas = $conn->query($queryPetugas)->fetch_assoc();

// Get recent borrowings
$query = "SELECT p.*,
          a.nama_anggota,
          pg.nama_petugas,
          GROUP_CONCAT(b.nama_buku SEPARATOR ', ') as nama_buku
          FROM PEMINJAMAN p
          LEFT JOIN ANGGOTA a ON p.id_anggota = a.id_anggota 
          LEFT JOIN PETUGAS pg ON p.id_petugas = pg.id_petugas
          LEFT JOIN DETAIL_PEMINJAMAN dp ON p.kode_pinjam = dp.kode_pinjam
          LEFT JOIN BUKU b ON dp.id_buku = b.id_buku
          GROUP BY p.kode_pinjam
          ORDER BY p.tanggal_pinjam DESC
          LIMIT 10";
$recentBorrowings = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Dashboard Perpustakaan</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .print-header { 
            text-align: center;
            margin-bottom: 30px;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            margin-top: 10px;
            color: #666;
        }
        @media print {
            .no-print { display: none; }
            .stat-box { 
                break-inside: avoid;
                border: 1px solid #000;
            }
        }
        /* Add table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-dipinjam { background: #d4edda; color: #155724; }
        .status-terlambat { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <div class="print-header">
        <h2>Laporan Statistik Perpustakaan</h2>
        <p>Tanggal: <?php echo date('d-m-Y'); ?></p>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-number"><?php echo $resultBuku['total_buku']; ?></div>
            <div class="stat-label">Total Buku</div>
        </div>
        <div class="stat-box"> 
            <div class="stat-number"><?php echo $resultAnggota['total_anggota']; ?></div>
            <div class="stat-label">Total Anggota</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?php echo $resultPeminjaman['total_peminjaman']; ?></div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?php echo $resultPetugas['total_petugas']; ?></div>
            <div class="stat-label">Total Petugas</div>
        </div>
    </div>

    <h3 class="section-title">Riwayat Peminjaman</h3>
    <table>
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $recentBorrowings->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div>
                            <strong><?php echo $row['nama_anggota']; ?></strong><br>
                            <small>ID: <?php echo $row['id_anggota']; ?></small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong><?php echo $row['nama_buku']; ?></strong><br>
                            <small>Staff: <?php echo $row['nama_petugas']; ?></small>
                        </div>
                    </td>
                    <td>
                        <?php echo date('d M Y', strtotime($row['tanggal_pinjam'])); ?><br>
                        <small><?php echo date('l', strtotime($row['tanggal_pinjam'])); ?></small>
                    </td>
                    <td>
                        <?php echo date('d M Y', strtotime($row['estimasi_pinjam'])); ?><br>
                        <small><?php echo date('l', strtotime($row['estimasi_pinjam'])); ?></small>
                    </td>
                    <td>
                        <span class="status-badge <?php echo $row['status'] == 'DIPINJAM' ? 'status-dipinjam' : ($row['status'] == 'DIKEMBALIKAN' ? 'status-dikembalikan' : 'status-terlambat'); ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button class="no-print" onclick="window.print()">Cetak Laporan</button>
</body>
</html>
