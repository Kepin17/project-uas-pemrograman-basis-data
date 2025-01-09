<?php
require_once('config/connection.php');



// Count queries
$totalBooksQuery = "SELECT COUNT(*) as total FROM buku";
$totalMembersQuery = "SELECT COUNT(*) as total FROM anggota";
$totalBorrowingsQuery = "SELECT COUNT(*) as total FROM peminjaman";

$totalBooksResult = mysqli_query($conn, $totalBooksQuery);
$totalMembersResult = mysqli_query($conn, $totalMembersQuery);
$totalBorrowingsResult = mysqli_query($conn, $totalBorrowingsQuery);

$totalBooks = mysqli_fetch_assoc($totalBooksResult)['total'];
$totalMembers = mysqli_fetch_assoc($totalMembersResult)['total'];
$totalBorrowings = mysqli_fetch_assoc($totalBorrowingsResult)['total'];

// Add pagination configuration
$records_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Modify the total records query to include all records
$total_query = "SELECT COUNT(*) as total FROM peminjaman";
$total_result = mysqli_query($conn, $total_query);
$total_records = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_records / $records_per_page);

$pageTitle = "Dashboard - Perpustakaan";
$currentPage = 'dashboard';

ob_start();
?>

<!-- Custom CSS for white theme with shadows -->
<style>
    .btn-white {
        background-color: white;
        border-color: #ced4da;
        color: #495057;
    }
    .btn-white:hover {
        background-color: #e9ecef;
        border-color: #ced4da;
    }
    .card-white {
        background-color: white;
        color: #495057;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .bg-white {
        background-color: white;
    }
    .bg-light-white {
        background-color: #f8f9fa;
    }
</style>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="printDashboard" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50 me-2"></i>Cetak Laporan
        </a>
    </div>
    <div class="row g-4 mb-4">
        <!-- Header Stats -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-white">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Buku</h6>
                    <h3 class="mb-0"><?php echo $totalBooks; ?></h3>
                    <div class="small text-success mt-2">
                        <i class="fas fa-book"></i> Total semua buku
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-white">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Anggota</h6>
                    <h3 class="mb-0"><?php echo $totalMembers; ?></h3>
                    <div class="small text-primary mt-2">
                        <i class="fas fa-users"></i> Total semua anggota
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-white">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Peminjaman</h6>
                    <h3 class="mb-0"><?php echo $totalBorrowings; ?></h3>
                    <div class="small text-danger mt-2">
                        <i class="fas fa-book"></i> Total semua peminjaman
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Borrowings Table -->
    <div class="card border-0 shadow-sm card-white">
        <div class="card-header bg-light-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Riwayat Peminjaman</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-white">
                        <tr>
                            <th class="border-0">Peminjam</th>
                            <th class="border-0">Buku</th>
                            <th class="border-0">Tanggal Pinjam</th>
                            <th class="border-0">Tanggal Kembali</th>
                            <th class="border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Modified query to show all borrowing history
                        $query = "SELECT p.*, 
                                  a.nama_anggota,
                                  pg.nama_petugas,
                                  b.nama_buku,
                                  b.stok
                                  FROM PEMINJAMAN p
                                  LEFT JOIN DETAIL_PEMINJAMAN dp ON p.kode_pinjam = dp.kode_pinjam
                                  LEFT JOIN ANGGOTA a ON p.id_anggota = a.id_anggota 
                                  LEFT JOIN PETUGAS pg ON p.id_petugas = pg.id_petugas
                                  LEFT JOIN BUKU b ON dp.id_buku = b.id_buku
                                  ORDER BY p.tanggal_pinjam DESC
                                  LIMIT $offset, $records_per_page";
                        $recentBorrowingsResult = mysqli_query($conn, $query);
                        while($borrowing = mysqli_fetch_assoc($recentBorrowingsResult)) { ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center py-2">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($borrowing['nama_anggota']); ?>&background=random" 
                                         class="rounded-circle me-3" width="40" height="40">
                                    <div>
                                        <div class="fw-semibold"><?php echo $borrowing['nama_anggota']; ?></div>
                                        <div class="text-muted small">ID: <?php echo $borrowing['id_anggota']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-semibold"><?php echo $borrowing['nama_buku']; ?></div>
                                        <div class="text-muted small">Staff: <?php echo $borrowing['nama_petugas']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <?php echo date('d M Y', strtotime($borrowing['tanggal_pinjam'])); ?>
                                    <div class="text-muted small"><?php echo date('l', strtotime($borrowing['tanggal_pinjam'])); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <?php echo date('d M Y', strtotime($borrowing['estimasi_pinjam'])); ?>
                                    <div class="text-muted small"><?php echo date('l', strtotime($borrowing['estimasi_pinjam'])); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start">
                                    <?php
                                    switch ($borrowing['status']) {
                                        case "DIPINJAM":
                                            echo '<span class="badge bg-success-subtle text-success">Dipinjam</span>';
                                            break;
                                        case "TERLAMBAT":
                                            echo '<span class="badge bg-warning-subtle text-warning">Terlambat</span>';
                                            break;
                                        case "DIKEMBALIKAN":
                                            echo '<span class="badge bg--subtle text-info">Dikembalikan</span>';
                                            break;
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light-white border-0 py-3">
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>" <?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    
                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $start_page + 4);
                    
                    if ($start_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                        if ($start_page > 2) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                    }
                    
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                              <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                            </li>';
                    }
                    
                    if ($end_page < $total_pages) {
                        if ($end_page < $total_pages - 1) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                    }
                    ?>
                    
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>" <?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
