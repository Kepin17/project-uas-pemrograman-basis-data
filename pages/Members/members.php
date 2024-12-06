<?php
require "config/connection.php";
$pageTitle = "Anggota Perpustakaan";
$currentPage = 'members';

$search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';

$query = "SELECT * FROM anggota WHERE 1";
// $query = "SELECT * FROM anggota ORDER BY id_anggota DESC";

if (!empty($search)) {
    $query .= " AND (nama_anggota LIKE '%search%'  OR email LIKE '%$search%' OR alamat LIKE '%$search%')";
}

$query .= " ORDER BY id_anggota DESC";

$ambilAnggota = $conn->query($query) or die(mysqli_error($conn));

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Anggota Perpustakaan</h4>
    <div class="btn-group">
        <a href="<?php echo BASE_URL; ?>/members/addMember" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Tambah Anggota
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="card my-3">
    <div class="card-body">
        <form method="GET" action="<?php echo BASE_URL; ?>/members">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari anggota..." value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pecahAnggota = $ambilAnggota->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold"><?= $pecahAnggota['nama_anggota'] ?></div>
                                        <small class="text-muted"><?= $pecahAnggota['id_anggota'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="fas fa-envelope me-1"></i><?= $pecahAnggota['email'] ?></div>
                                <small><i class="fas fa-phone me-1"></i><?= $pecahAnggota['nomor_telp'] ?></small>
                            </td>
                            <td><?= $pecahAnggota['alamat'] ?></td>
                            <td><?= date('d M Y', strtotime($pecahAnggota['created_at'])) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/members/editMember?id=<?= $pecahAnggota['id_anggota'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/members/deleteMember?id=<?= $pecahAnggota['id_anggota'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus anggota?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>