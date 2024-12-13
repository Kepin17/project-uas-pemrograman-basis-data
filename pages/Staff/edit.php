<?php
require "config/connection.php";
$pageTitle = "Edit Staff";
$currentPage = 'staff';

$id = $_GET['id'];
$query = "SELECT * FROM petugas WHERE id_petugas = '$id'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

$jabatanQuery = "SELECT id_jabatan, nama_jabatan FROM jabatan";
$jabatanResult = $conn->query($jabatanQuery) or die(mysqli_error($conn));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_petugas = $_POST['nama_petugas'];
    $email = $_POST['email'];
    $nomor_telp = $_POST['nomor_telp'];
    $id_jabatan = $_POST['id_jabatan'];

    $query = "UPDATE petugas SET 
              nama_petugas = '$nama_petugas', email = '$email', nomor_telp = '$nomor_telp', id_jabatan = '$id_jabatan'
              WHERE id_petugas = '$id'";

    $conn->query($query) or die(mysqli_error($conn));
    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/staff?success=mengedit staff");
        exit;
    } else {
        die("Gagal mengedit staff: " . $conn->error);
    }
}

ob_start();
?>

<h4 class="mb-3">Edit Buku</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Petugas</label>
            <input type="text" name="nama_petugas" value="<?= $data['nama_petugas'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="text" name="email" value="<?= $data['email'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="nomor_telp" value="<?= $data['nomor_telp'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="id_jabatan" class="form-select" required>
                <option value="" disabled>Pilih Kategori</option>
                <?php while ($jabatan = $jabatanResult->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($jabatan['id_jabatan']) ?>"
                        <?= $jabatan['id_jabatan'] == $data['id_jabatan'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($jabatan['nama_jabatan']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="text-end mt-3">
            <a href="<?php echo BASE_URL; ?>/staff" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>