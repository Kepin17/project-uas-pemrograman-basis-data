<?php
require "config/connection.php";
$pageTitle = "Manajemen Buku - Perpustakaan";
$currentPage = 'books';

$search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';

$query = "SELECT buku.*, kategori_buku.nama_kategori FROM buku LEFT JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori";

if (!empty($search)) {
    $query .= " WHERE (buku.nama_buku LIKE '%$search%'
     OR buku.tahun_terbit LIKE '%$search%'
      OR buku.kode_rak LIKE '%$search%')";
}

$query .= " ORDER BY buku.id_buku DESC";

$result = $conn->query($query) or die(mysqli_error($conn));

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Manajemen Buku - Perpustakaan</h4>
    <a href="<?php echo BASE_URL; ?>/books/addBook" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Tambah Buku
    </a>
</div>

<div class="card my-3">
    <div class="card-body">
        <form method="GET" action="<?php echo BASE_URL; ?>/books">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari buku..." value="<?php echo htmlspecialchars($search); ?>">
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
                        <th>Nama Buku</th>
                        <th>Tahun terbit</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($buku = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($buku['nama_buku']) ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($buku['id_buku']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($buku['tahun_terbit'])) ?></td>
                            <td><?= htmlspecialchars($buku['stok'] ?? '') ?></td>
                            <td>
                                <div><i class="fas fa-list me-1"></i><?= htmlspecialchars($buku['nama_kategori'] ?? '') ?></div>
                                <small><i class="fas fa-table me-1"></i><?= htmlspecialchars($buku['kode_rak'] ?? '') ?></small>
                            </td>
                            <!-- <td><?= htmlspecialchars($buku['alamat']) ?></td> -->
                            <!-- <td><?= date('d M Y', strtotime($buku['created_at'])) ?></td> -->
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/books/editBook?id=<?= urlencode($buku['id_buku']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/books/deleteBook?id=<?= urlencode($buku['id_buku']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus anggota?')">
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