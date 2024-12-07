<?php
require "config/connection.php";
$pageTitle = "Kategori Buku - Perpustakaan";
$currentPage = 'categories';

$query = "SELECT * FROM kategori_buku ORDER BY id_kategori DESC";
$result = $conn->query($query);

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Kategori Buku</h4>
    <div class="btn-group">
        <a href="<?php echo BASE_URL; ?>/categories/addCategory" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Tambah Kategori
        </a>
    </div>
</div>

<!-- List View -->
<div id="listView">
    <!-- Categories Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <!-- <th>Jumlah Buku</th> -->
                            <!-- <th>Status</th> -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                            while ($kategori = $result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $no++?></td>
                            <td><?= $kategori['nama_kategori']?></td>
                            <!-- <td>30</td> -->
                            <!-- <td><span class="badge bg-success">Aktif</span></td> -->
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/categories/editCategory?id=<?= urlencode($kategori['id_kategori']) ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/categories/deleteCategory?id=<?= urlencode($kategori['id_kategori']) ?>" class="btn btn-sm btn-danger">
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
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
