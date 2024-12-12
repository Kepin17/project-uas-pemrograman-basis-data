<?php
require "config/connection.php";

$pageTitle = "Rak Buku - Perpustakaan";
$currentPage = 'shelves';

ob_start();

// Ambil data rak buku dari database
$query = "SELECT * FROM rak_buku";
$result = $conn->query($query);
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Rak Buku</h4>
    <div class="btn-group">
        <a href="<?php echo BASE_URL; ?>/shelves/addShelve" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Tambah Rak
        </a>
    </div>
</div>

<!-- List View -->
<div id="listView">
    <div class="row g-4">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0"><?= htmlspecialchars($row['kode_rak']) ?></h5>
                        <div class="btn-group">
                            <a href="<?php echo BASE_URL; ?>/shelves/editShelve?id=<?= urlencode($row['kode_rak']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/shelves/deleteShelve?id=<?= urlencode($row['kode_rak']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus rak ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <small class="text-muted">Nama Rak</small>
                            <div><?= $row['nama_rak'] ?></div>
                        </div>
                    </div>
                 
                    <div class="flex gap-2">
                        <i class="fa-solid fa-location-dot"></i>
                        <?= htmlspecialchars($row['lokasi']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
