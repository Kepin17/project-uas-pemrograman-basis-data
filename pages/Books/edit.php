<?php
require "config/connection.php";
$pageTitle = "Edit Buku";
$currentPage = 'books';

$id = $_GET['id'];
$query = "SELECT * FROM buku WHERE id_buku = '$id'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

$kategoriQuery = "SELECT id_kategori, nama_kategori FROM kategori_buku";
$kategoriResult = $conn->query($kategoriQuery) or die(mysqli_error($conn));

$rakQuery = "SELECT kode_rak, nama_rak FROM rak_buku";
$rakResult = $conn->query($rakQuery) or die(mysqli_error($conn));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_buku = $_POST['nama_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];
    $id_kategori = $_POST['id_kategori'];
    $kode_rak = $_POST['kode_rak'];

    $query = "UPDATE buku SET 
              nama_buku = '$nama_buku', tahun_terbit = '$tahun_terbit', stok = '$stok', id_kategori = '$id_kategori', kode_rak = '$kode_rak'
              WHERE id_buku = '$id'";

    $conn->query($query) or die(mysqli_error($conn));
    header("Location: " . BASE_URL . "/books");
}

ob_start();
?>

<h4 class="mb-3">Edit Buku</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Buku</label>
            <input type="text" name="nama_buku" value="<?= $data['nama_buku'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tahun Terbit</label>
            <input type="date" name="tahun_terbit" value="<?= $data['tahun_terbit'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" value="<?= $data['stok'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="id_kategori" class="form-select" required>
                <option value="" disabled>Pilih Kategori</option>
                <?php while ($kategori = $kategoriResult->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($kategori['id_kategori']) ?>"
                        <?= $kategori['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kategori['nama_kategori']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kode Rak</label>
            <select name="kode_rak" class="form-select" required>
                <option value="" disabled>Pilih Kode Rak</option>
                <?php while ($rak = $rakResult->fetch_assoc()){ ?>
                    <option value="<?= htmlspecialchars($rak['kode_rak']) ?>"
                        <?= $rak['kode_rak'] == $data['kode_rak'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($rak['nama_rak']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="text-end mt-3">
            <a href="<?php echo BASE_URL; ?>/books" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>