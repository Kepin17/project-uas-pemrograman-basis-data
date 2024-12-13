<?php
require "config/connection.php";
$pageTitle = "Edit Jabatan";
$currentPage = 'members';

$id = $_GET['id'];
$query = "SELECT * FROM jabatan WHERE id_jabatan = '$id'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_jabatan = $_POST['nama_jabatan'];

    $query = "UPDATE jabatan SET nama_jabatan = '$nama_jabatan' WHERE id_jabatan = '$id'";
    $conn->query($query) or die(mysqli_error($conn));
    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/position?success=mengdit jabatan"); // Redirect ke halaman utama
        exit;
    } else {
        die("Gagal menambahkan jabatan: " . $conn->error);
    }
}

ob_start();
?>

<h4 class="mb-3">Edit Jabatan</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama jabatan</label>
            <input type="text" name="nama_jabatan" value="<?= $data['nama_jabatan'] ?>" class="form-control" required>
        </div>
    </div>
    <div class="text-end mt-3">
        <a href="<?php echo BASE_URL; ?>/position" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
