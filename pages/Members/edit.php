<?php
require "config/connection.php";
$pageTitle = "Edit Anggota";
$currentPage = 'members';

$id = $_GET['id'];
$query = "SELECT * FROM anggota WHERE id_anggota = '$id'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_telp = $_POST['nomor_telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE anggota SET 
              nama_anggota = '$nama', email = '$email', nomor_telp = '$nomor_telp', alamat = '$alamat'
              WHERE id_anggota = '$id'";
    $conn->query($query) or die(mysqli_error($conn));
    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/members?success=menambahkan anggota");
        exit;
      } else {
        die("Gagal menambahkan kategori: " . $conn->error);
      }
    
}

ob_start();
?>

<h4 class="mb-3">Edit Anggota</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" value="<?= $data['nama_anggota'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" name="nomor_telp" value="<?= $data['nomor_telp'] ?>" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required><?= $data['alamat'] ?></textarea>
        </div>
    </div>
    <div class="text-end mt-3">
        <a href="<?php echo BASE_URL; ?>/members" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
