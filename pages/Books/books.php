<?php
require "config/connection.php";
$pageTitle = "Manajemen Buku - Perpustakaan";
$currentPage = 'books';

$search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';
$successMessage = isset($_GET['success']) ? $_GET['success'] : '';

// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total records
$countQuery = "SELECT COUNT(*) as total FROM buku";
$countResult = $conn->query($countQuery);
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

$query = "SELECT buku.*, kategori_buku.nama_kategori FROM buku LEFT JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori";

if (!empty($search)) {
    $query .= " WHERE (buku.nama_buku LIKE '%$search%'
     OR buku.tahun_terbit LIKE '%$search%'
      OR buku.kode_rak LIKE '%$search%')";
}

$query .= " ORDER BY buku.id_buku DESC LIMIT $limit OFFSET $offset";

$result = $conn->query($query) or die(mysqli_error($conn));

ob_start();
?>

<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

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

    .btn-pink {
        background-color: #ff69b4;
        color:rgb(255, 255, 255);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .btn-pink:hover {
        background-color: #ff85c1;
        color:rgb(255, 255, 255);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .bg-white {
        background-color: white;
    }
    .bg-light-white {
        background-color: #f8f9fa;
    }
    .pagination .page-item.active .page-link {
        background-color: #343a40;
        border-color: #343a40;
        color: #ffff;
    }
    .pagination .page-item .page-link {
        color: #343a40;
    }
    .pagination {
        margin-top: 20px;
    }
    .table th, .table td {
        width: 20%;
    }
</style>

<script>
    function confirmAction(action, url) {
        Swal.fire({
            title: `Are you sure you want to ${action} this book?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
        return false;
    }

    function showSuccessMessage(message) {
        Swal.fire({
            title: 'Success!',
            text: message,
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = "<?php echo $successMessage; ?>";
        if (successMessage) {
            showSuccessMessage(successMessage);
        }
    });
</script>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Manajemen Buku - Perpustakaan</h4>
    <a href="<?php echo BASE_URL; ?>/books/addBook" class="btn btn-pink" onclick="return confirmAction('add', '<?php echo BASE_URL; ?>/books/addBook');">
        <i class="fas fa-plus me-2"></i>Tambah Buku
    </a>
</div>

<div class="card my-3 card-white">
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

<div class="card mt-4 card-white">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light-white">
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
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/books/editBook?id=<?= urlencode($buku['id_buku']) ?>" class="btn btn-sm btn-warning" title="Edit" onclick="return confirmAction('edit', '<?php echo BASE_URL; ?>/books/editBook?id=<?= urlencode($buku['id_buku']) ?>');">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/books/deleteBook?id=<?= urlencode($buku['id_buku']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirmAction('delete', '<?php echo BASE_URL; ?>/books/deleteBook?id=<?= urlencode($buku['id_buku']) ?>');">
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

<!-- Pagination Controls -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="<?php if($page > 1) echo '?page=' . ($page - 1); ?>">Previous</a>
        </li>
        <?php for($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php if($page == $i) echo 'active'; ?>">
                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if($page >= $totalPages) echo 'disabled'; ?>">
            <a class="page-link" href="<?php if($page < $totalPages) echo '?page=' . ($page + 1); ?>">Next</a>
        </li>
    </ul>
</nav>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>