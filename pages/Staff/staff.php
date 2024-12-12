<?php
require "config/connection.php";
$pageTitle = "Staff Perpustakaan";
$currentPage = 'staff';

$search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';

$query = "SELECT petugas.*, jabatan.nama_jabatan FROM petugas LEFT JOIN jabatan ON petugas.id_jabatan = jabatan.id_jabatan";

if (!empty($search)) {
    $query .= " WHERE (petugas.nama_petugas LIKE '%$search%' OR petugas.email LIKE '%$search%' OR petugas.nomor_telp LIKE '%$search%')";
}

$query .= " ORDER BY petugas.id_petugas DESC";

$data = $conn->query($query) or die(mysqli_error($conn));

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Petugas Perpustakaan</h4>
    <a href="<?php echo BASE_URL; ?>/staff/addStaff" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Tambah Petugas
    </a>
</div>

<div class="card my-3">
    <div class="card-body">
        <form method="GET" action="<?php echo BASE_URL; ?>/staff">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Petugas..." value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Petugas</th>
                        <th>Kontak</th>
                        <th>Jabatan</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($staff = $data->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($staff['nama_petugas']) ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($staff['id_petugas']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="fas fa-envelope me-1"></i><?= htmlspecialchars($staff['email']) ?></div>
                                <small><i class="fas fa-phone me-1"></i><?= htmlspecialchars($staff['nomor_telp']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($staff['nama_jabatan']) ?></td>
                            <td><?= date('d M Y', strtotime($staff['created_at'])) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/staff/editStaff?id=<?= urlencode($staff['id_petugas']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/staff/deleteStaff?id=<?= urlencode($staff['id_petugas']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus anggota?')">
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