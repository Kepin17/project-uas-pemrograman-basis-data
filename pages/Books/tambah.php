<?php
require "config/connection.php";
$pageTitle = "Tambah Buku";
$currentPage = 'books';

function generateIdBuku($conn) {
  $query = "SELECT id_buku FROM buku ORDER BY id_buku DESC LIMIT 1";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastId = $row['id_buku']; 
    $number = (int) substr($lastId, 2);
    $newNumber = $number + 1;
  } else {
    $newNumber = 1;
  }

  return 'BK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

$kategoriQuery = "SELECT id_kategori, nama_kategori FROM kategori_buku";
$kategoriResult = $conn->query($kategoriQuery) or die(mysqli_error($conn));

$rakQuery = "SELECT kode_rak, nama_rak FROM rak_buku";
$rakResult = $conn->query($rakQuery) or die(mysqli_error($conn));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_buku = generateIdBuku($conn);
  $nama_buku = $_POST['nama_buku'];
  $tahun_terbit = $_POST['tahun_terbit'];
  $stok = $_POST['stok'];
  $id_kategori = $_POST['id_kategori'];
  $kode_rak = $_POST['kode_rak'];

  $query = "INSERT INTO buku (id_buku, nama_buku, tahun_terbit, stok, id_kategori, kode_rak) 
        VALUES ('$id_buku', '$nama_buku', '$tahun_terbit', '$stok', '$id_kategori', '$kode_rak')";

  if ($conn->query($query)) {
    header("Location: " . BASE_URL . "/books?success=menambahkan buku");
    exit;
  } else {
    die("Gagal menambahkan buku: " . $conn->error);
  }
}

ob_start();
?>

<h4 class="mb-3">Tambah Buku Baru</h4>
<form method="POST">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nama Buku</label>
      <input type="text" name="nama_buku" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Tahun Terbit</label>
      <input type="date" name="tahun_terbit" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Stok</label>
      <input type="number" name="stok" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label" for="">Kategori</label>
      <select name="id_kategori" id="id_kategori" class="form-select" required>
      <option value="" disabled selected>Pilih Kategori</option>
      <?php while ($kategori = $kategoriResult->fetch_assoc()): ?>
        <option value="<?= htmlspecialchars($kategori['id_kategori']) ?>">
        <?= htmlspecialchars($kategori['nama_kategori'])?>
        </option>
      <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label" for="">Kode Rak</label>
      <select name="kode_rak" id="kode_rak" class="form-select" required>
      <option value="" disabled selected>Pilih Kode Rak</option>
      <?php while ($rak = $rakResult->fetch_assoc()): ?>
        <option value="<?= htmlspecialchars($rak['kode_rak'])?>">
        <?= htmlspecialchars($rak['nama_rak'])?>
        </option>
      <?php endwhile; ?>
      </select>
    </div>
  </div>
  <div class="text-end mt-3">
    <a href="<?php echo BASE_URL; ?>/books" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
<script>
  alert('Buku berhasil ditambahkan!');
</script>
<?php endif; ?>
