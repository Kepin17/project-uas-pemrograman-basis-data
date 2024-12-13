<?php
require "config/connection.php";
$pageTitle = "Manajemen Kategori - Perpustakaan";
$currentPage = 'categories';

$search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';
$successMessage = isset($_GET['success']) ? $_GET['success'] : '';

$query = "SELECT * FROM kategori_buku";

if (!empty($search)) {
    $query .= " WHERE nama_kategori LIKE '%$search%'";
}

$query .= " ORDER BY id_kategori DESC";

$result = $conn->query($query) or die(mysqli_error($conn));

ob_start();
?>

<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!-- Custom CSS for pink and purple theme -->
<style>
    .btn-pink {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
    }
    .btn-pink:hover {
        background-color: #ff85c1;
        border-color: #ff85c1;
    }
    .card-pink {
        background-color: #ffb6c1;
    }
    .card-purple {
        background-color: #dda0dd;
    }
    .bg-light-pink {
        background-color: #ffe4e1;
    }
    .bg-light-purple {
        background-color: #e6e6fa;
    }
</style>

<script>
    function confirmAction(action, url) {
        Swal.fire({
            title: `Are you sure you want to ${action} this category?`,
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
    <h4 class="mb-0">Manajemen Kategori - Perpustakaan</h4>
    <a href="<?php echo BASE_URL; ?>/categories/addCategory" class="btn btn-pink" onclick="return confirmAction('add', '<?php echo BASE_URL; ?>/categories/addCategory');">
        <i class="fas fa-plus me-2"></i>Tambah Kategori
    </a>
</div>

<div class="card my-3">
    <div class="card-body">
        <form method="GET" action="<?php echo BASE_URL; ?>/categories">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="<?php echo htmlspecialchars($search); ?>">
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
                <thead class="bg-light-purple">
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($kategori = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($kategori['nama_kategori']) ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($kategori['id_kategori']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/categories/editCategory?id=<?= urlencode($kategori['id_kategori']) ?>" class="btn btn-sm btn-warning" title="Edit" onclick="return confirmAction('edit', '<?php echo BASE_URL; ?>/categories/editCategory?id=<?= urlencode($kategori['id_kategori']) ?>');">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/categories/deleteCategory?id=<?= urlencode($kategori['id_kategori']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirmAction('delete', '<?php echo BASE_URL; ?>/categories/deleteCategory?id=<?= urlencode($kategori['id_kategori']) ?>');">
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
