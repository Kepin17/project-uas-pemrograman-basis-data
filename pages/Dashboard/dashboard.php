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
                    <h5 class="mb-0">Peminjaman Terbaru</h5>
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
                        $recentBorrowingsQuery = "SELECT peminjaman.*, 
                                                         anggota.nama_anggota,
                                                         buku.nama_buku
                                                  FROM peminjaman 
                                                  JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota
                                                  JOIN buku ON peminjaman.id_buku = buku.id_buku
                                                  ORDER BY peminjaman.tanggal_pinjam DESC
                                                  LIMIT 5";
                        $recentBorrowingsResult = mysqli_query($conn, $recentBorrowingsQuery);
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
                                        <div class="text-muted small">ID: <?php echo $borrowing['id_buku']; ?></div>
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
                                            echo '<span class="badge bg-info-subtle text-info">Dikembalikan</span>';
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
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
