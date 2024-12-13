<?php
require "config/connection.php";

$pageTitle = "Rak Buku - Perpustakaan";
$currentPage = 'shelves';

$search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';
$successMessage = isset($_GET['success']) ? $_GET['success'] : '';

$query = "SELECT * FROM rak_buku";

if (!empty($search)) {
    $query .= " WHERE (nama_rak LIKE '%$search%')";
}

$query .= " ORDER BY kode_rak DESC";

$result = $conn->query($query) or die(mysqli_error($conn));

ob_start();
?>

<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!-- Custom CSS for pink button -->
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
</style>

<script>
    function confirmAction(action, url) {
        Swal.fire({
            title: `Are you sure you want to ${action} this shelf?`,
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
    <h4 class="mb-0">Rak Buku</h4>
    <div class="btn-group">
        <a href="<?php echo BASE_URL; ?>/shelves/addShelve" class="btn btn-pink" onclick="return confirmAction('add', '<?php echo BASE_URL; ?>/shelves/addShelve');">
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
                            <a href="<?php echo BASE_URL; ?>/shelves/editShelve?id=<?= urlencode($row['kode_rak']) ?>" class="btn btn-sm btn-warning" onclick="return confirmAction('edit', '<?php echo BASE_URL; ?>/shelves/editShelve?id=<?= urlencode($row['kode_rak']) ?>');">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/shelves/deleteShelve?id=<?= urlencode($row['kode_rak']) ?>" class="btn btn-sm btn-danger" onclick="return confirmAction('delete', '<?php echo BASE_URL; ?>/shelves/deleteShelve?id=<?= urlencode($row['kode_rak']) ?>');">
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
