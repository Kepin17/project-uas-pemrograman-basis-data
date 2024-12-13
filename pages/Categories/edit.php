<?php
require "config/connection.php";
$pageTitle = "Edit Rak Buku";
$currentPage = 'categories';

$id_kategori = $_GET['id'];
$query = "SELECT * FROM kategori_buku WHERE id_kategori = '$id_kategori'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];

    $query = "UPDATE kategori_buku SET 
              nama_kategori = '$nama_kategori'
              WHERE id_kategori = '$id_kategori'";
    $conn->query($query) or die(mysqli_error($conn));
    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/categories?success=menambahkan buku");
        exit;
      } else {
        die("Gagal menambahkan buku: " . $conn->error);
      }
}

ob_start();
?>

<h4 class="mb-3">Edit Kategori Buku</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Kode Rak</label>
            <input type="text" name="id_kategori" class="form-control" value="<?php echo $data['id_kategori']; ?>" disabled>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Rak</label>
            <input type="text" name="nama_kategori" class="form-control" value="<?php echo $data['nama_kategori']; ?>" required>
        </div>
    </div>
    <div class="mt-3">
        <a href="<?php echo BASE_URL; ?>/categories " class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>