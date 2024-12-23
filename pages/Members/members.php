<?php
require "config/connection.php";
$pageTitle = "Manajemen Anggota - Perpustakaan";
$currentPage = 'members';

$search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';
$successMessage = isset($_GET['success']) ? $_GET['success'] : '';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Count total records for pagination
$countQuery = "SELECT COUNT(*) as total FROM anggota";
if (!empty($search)) {
    $countQuery .= " WHERE nama_anggota LIKE '%$search%' OR id_anggota LIKE '%$search%'";
}
$countResult = $conn->query($countQuery);
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Modified main query with LIMIT
$query = "SELECT * FROM anggota";
if (!empty($search)) {
    $query .= " WHERE nama_anggota LIKE '%$search%' OR id_anggota LIKE '%$search%'";
}
$query .= " ORDER BY id_anggota DESC LIMIT $start, $limit";

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
            title: `Are you sure you want to ${action} this member?`,
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
    <h4 class="mb-0">Manajemen Anggota - Perpustakaan</h4>
    <a href="<?php echo BASE_URL; ?>/members/addMember" class="btn btn-pink" onclick="return confirmAction('add', '<?php echo BASE_URL; ?>/members/addMember');">
        <i class="fas fa-plus me-2"></i>Tambah Anggota
    </a>
</div>

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

<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light-purple">
                    <tr>
                        <th>ID Anggota</th>
                        <th>Nama Anggota</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($anggota = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($anggota['id_anggota']) ?></td>
                            <td><?= htmlspecialchars($anggota['nama_anggota']) ?></td>
                            <td><?= htmlspecialchars($anggota['email']) ?></td>
                            <td><?= htmlspecialchars($anggota['nomor_telp']) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/members/editMember?id=<?= urlencode($anggota['id_anggota']) ?>" class="btn btn-sm btn-warning" title="Edit" onclick="return confirmAction('edit', '<?php echo BASE_URL; ?>/members/editMember?id=<?= urlencode($anggota['id_anggota']) ?>');">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/members/deleteMember?id=<?= urlencode($anggota['id_anggota']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirmAction('delete', '<?php echo BASE_URL; ?>/members/deleteMember?id=<?= urlencode($anggota['id_anggota']) ?>');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <!-- Pagination Controls -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page-1; ?><?php echo !empty($search) ? '&search='.$search : ''; ?>" 
                           <?php echo ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Previous</a>
                    </li>
                    
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search='.$search : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page+1; ?><?php echo !empty($search) ? '&search='.$search : ''; ?>"
                           <?php echo ($page >= $totalPages) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Next</a>
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