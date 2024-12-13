<?php
require_once('config/connection.php');
require_once('includes/check_late_returns.php');

// Define status constants
define('STATUS_DIPINJAM', 1);
define('STATUS_TERLAMBAT', 2);
define('STATUS_DIKEMBALIKAN', 3);

// Update late returns
updateLateReturns();

// Count queries
$totalPeminjamanQuery = "SELECT COUNT(*) as total FROM peminjaman";
$sedangDipinjamQuery = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'DIPINJAM'";
$terlambatQuery = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'TERLAMBAT'";

$totalResult = mysqli_query($conn, $totalPeminjamanQuery);
$dipinjamResult = mysqli_query($conn, $sedangDipinjamQuery);
$terlambatResult = mysqli_query($conn, $terlambatQuery);

$totalPeminjaman = mysqli_fetch_assoc($totalResult)['total'];
$sedangDipinjam = mysqli_fetch_assoc($dipinjamResult)['total'];
$terlambat = mysqli_fetch_assoc($terlambatResult)['total'];

$pageTitle = "Peminjaman Buku - Perpustakaan";
$currentPage = 'borrowing';

// Update the query to join with all related tables
$peminjamanQuery = "SELECT peminjaman.*, 
                           anggota.nama_anggota,
                           buku.nama_buku,
                           petugas.nama_petugas
                    FROM peminjaman 
                    JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota
                    JOIN buku ON peminjaman.id_buku = buku.id_buku
                    JOIN petugas ON peminjaman.id_petugas = petugas.id_petugas";
$peminjamanResult = mysqli_query($conn, $peminjamanQuery);

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
                    <h6 class="text-muted mb-2">Total Peminjaman</h6>
                    <h3 class="mb-0"><?php echo $totalPeminjaman; ?></h3>
                    <div class="small text-success mt-2">
                        <i class="fas fa-book"></i> Total semua peminjaman
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-white">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Sedang Dipinjam</h6>
                    <h3 class="mb-0"><?php echo $sedangDipinjam; ?></h3>
                    <div class="small text-primary mt-2">
                        <i class="fas fa-book"></i> Buku yang sedang dipinjam
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-white">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Terlambat</h6>
                    <h3 class="mb-0"><?php echo $terlambat; ?></h3>
                    <div class="small text-danger mt-2">
                        <i class="fas fa-clock"></i> Perlu tindak lanjut
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card border-0 shadow-sm mb-4 card-white">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari peminjam atau buku...">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select">
                        <option value="">Semua Status</option>
                        <option value="1">Dipinjam</option>
                        <option value="2">Terlambat</option>
                        <option value="3">Dikembalikan</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <input type="date" class="form-control">
                </div>
                <div class="col-12 col-md-2 d-grid">
                    <button class="btn btn-white">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowing Table -->
    <div class="card border-0 shadow-sm card-white">
        <div class="card-header bg-light-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Daftar Peminjaman</h5>
                </div>
                <div class="col text-end">
                    <button class="btn btn-white" data-bs-toggle="modal" data-bs-target="#modalPeminjamanBaru">
                        <i class="fas fa-plus me-2"></i>Peminjaman Baru
                    </button>
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
                            <th class="border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($peminjaman = mysqli_fetch_assoc($peminjamanResult)) { ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center py-2">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($peminjaman['nama_anggota']); ?>&background=random" 
                                         class="rounded-circle me-3" width="40" height="40">
                                    <div>
                                        <div class="fw-semibold"><?php echo $peminjaman['nama_anggota']; ?></div>
                                        <div class="text-muted small">ID: <?php echo $peminjaman['id_anggota']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-semibold"><?php echo $peminjaman['nama_buku']; ?></div>
                                        <div class="text-muted small">ID: <?php echo $peminjaman['id_buku']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <?php echo date('d M Y', strtotime($peminjaman['tanggal_pinjam'])); ?>
                                    <div class="text-muted small"><?php echo date('l', strtotime($peminjaman['tanggal_pinjam'])); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <?php echo date('d M Y', strtotime($peminjaman['estimasi_pinjam'])); ?>
                                    <div class="text-muted small"><?php echo date('l', strtotime($peminjaman['estimasi_pinjam'])); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start">
                                    <?php
                                    switch ($peminjaman['status']) {
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
                                    <div class="mt-1 text-muted small">staff : <?php echo $peminjaman['nama_petugas']; ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-light btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-light btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-light btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

<!-- Modal Peminjaman Baru -->
<div class="modal fade" id="modalPeminjamanBaru" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <h5 class="modal-title">Peminjaman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="pages/Borrowing/proses_tambah.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">Pilih Anggota</option>
                            <?php
                            $query = "SELECT id_anggota, nama_anggota FROM anggota";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id_anggota']}'>{$row['nama_anggota']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Buku</label>
                        <select name="id_buku" class="form-select" required>
                            <option value="">Pilih Buku</option>
                            <?php
                            $query = "SELECT id_buku, nama_buku, stok FROM buku WHERE stok > 0";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id_buku']}'>{$row['nama_buku']} | sisa : {$row['stok']} </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estimasi Pengembalian</label>
                        <input type="date" name="estimasi_pinjam" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add this before closing body tag -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status changes
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const status = this.dataset.status;
            const button = this.closest('.dropdown').querySelector('.btn-status');
            const peminjamanId = button.dataset.id;
            
            // Update status via AJAX
            updateStatus(peminjamanId, status, button);
        });
    });
});

function updateStatus(peminjamanId, status, button) {
    fetch('api/update-status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_peminjaman: peminjamanId,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button appearance
            updateStatusButton(button, status);
            // Show success toast
            showToast('Status berhasil diperbarui', 'success');
        } else {
            showToast('Gagal memperbarui status', 'error');
        }
    })
    .catch(error => {
        showToast('Terjadi kesalahan', 'error');
    });
}

function updateStatusButton(button, status) {
    const statusClasses = {
        '1': ['bg-success-subtle text-success', 'Dipinjam'],
        '2': ['bg-warning-subtle text-warning', 'Terlambat'],
        '3': ['bg-info-subtle text-info', 'Dikembalikan']
    };

    // Remove all possible status classes
    button.className = 'btn btn-status dropdown-toggle';
    
    if (statusClasses[status]) {
        button.classList.add(...statusClasses[status][0].split(' '));
        button.textContent = statusClasses[status][1];
    }
}

function showToast(message, type) {
    // Add your preferred toast notification here
    alert(message); // Simple alternative
}
</script>

<style>
.btn-status {
    border: none;
    padding: 0.375rem 0.75rem;
    border-radius: 50rem;
    font-size: 0.875rem;
}
.bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
.bg-info-subtle { background-color: rgba(13, 202, 240, 0.1); }
.text-warning { color: #ffc107 !important; }
.text-info { color: #0dcaf0 !important; }
</style>
