<?php
require "config/connection.php";
$pageTitle = "Edit Rak Buku";
$currentPage = 'shelves';

$kode_rak = $_GET['id'];
$query = "SELECT * FROM rak_buku WHERE kode_rak = '$kode_rak'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_rak = $_POST['nama_rak'];

    $query = "UPDATE rak_buku SET 
              nama_rak = '$nama_rak'
              WHERE kode_rak = '$kode_rak'";
    $conn->query($query) or die(mysqli_error($conn));
    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/shelves?success=menambahkan Rak");
        exit;
    } else {
        die("Gagal menambahkan Rak: " . $conn->error);
    }
}

ob_start();
?>

<h4 class="mb-3">Edit Rak Buku</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Kode Rak</label>
            <input type="text" name="kode_rak" class="form-control" value="<?php echo $data['kode_rak']; ?>" disabled>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Rak</label>
            <input type="text" name="nama_rak" class="form-control" value="<?php echo $data['nama_rak']; ?>" required>
        </div>
    </div>
    <div class="mt-3">
        <a href="<?php echo BASE_URL; ?>/shelves" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>