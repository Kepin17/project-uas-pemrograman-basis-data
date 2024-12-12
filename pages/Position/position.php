<?php
require "config/connection.php";
$pageTitle = "Manajemen Jabatan - Perpustakaan";
$currentPage = 'position';

$query = "SELECT * from jabatan ORDER BY id_jabatan DESC";

$data = $conn->query($query) or die(mysqli_error($conn));

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Manajemen Jabatan</h4>
    <a href="<?php echo BASE_URL; ?>/position/addPosition" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Tambah Jabatan
    </a>
</div>

<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($jabatan = $data->fetch_assoc()):
                        $no = 1;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($jabatan['nama_jabatan']) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/position/editPosition?id=<?= urlencode($jabatan['id_jabatan']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/position/deletePosition?id=<?= urlencode($jabatan['id_jabatan']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus anggota?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>