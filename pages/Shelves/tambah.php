<?php
require "config/connection.php";
$pageTitle = "Tambah Rak Buku - Perpustakaan";
$currentPage = 'shelves';

function generateIdRak($conn)
{
  $query = "SELECT kode_rak FROM rak_buku ORDER BY kode_rak DESC LIMIT 1";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastId = $row['kode_rak'];
    $number = (int) substr($lastId, 2);
    $newNumber = $number + 1;
  } else {
    $newNumber = 1;
  }

  return 'RB' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_rak = $_POST['nama_rak'];

  $kode_rak = generateIdRak($conn);

  $query = "INSERT INTO rak_buku (kode_rak, nama_rak) VALUES ('$kode_rak', '$nama_rak')";

  if ($conn->query($query)) {
    header("Location: " . BASE_URL . "/shelves");
    exit;
  } else {
    die("Gagal menambahkan rak: " . $conn->error);
  }
}

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0">Tambah Rak Buku</h4>
</div>

<div class="card mt-4">
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Rak</label>
          <input type="text" name="nama_rak" class="form-control" required>
        </div>
      </div>
      <div class="text-end mt-3">
        <a href="<?php echo BASE_URL; ?>/shelves" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>