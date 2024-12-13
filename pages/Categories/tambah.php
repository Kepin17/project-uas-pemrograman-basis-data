<?php
require "config/connection.php";
$pageTitle = "Tambah Kategori Buku - Perpustakaan";
$currentPage = 'categories';

function generateIdCategory($conn)
{
  $query = "SELECT id_kategori FROM kategori_buku ORDER BY id_kategori DESC LIMIT 1";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastId = $row['id_kategori'];
    $number = (int) substr($lastId, 2);
    $newNumber = $number + 1;
  } else {
    $newNumber = 1;
  }

  return 'KB' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_kategori = $_POST['nama_kategori'];

  $id_kategori = generateIdCategory($conn);

  $query = "INSERT INTO kategori_buku (id_kategori, nama_kategori) VALUES ('$id_kategori', '$nama_kategori')";

  if ($conn->query($query)) {
    header("Location: " . BASE_URL . "/categories?success=menambahkan kategori");
    exit;
  } else {
    die("Gagal menambahkan kategori: " . $conn->error);
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
          <label class="form-label">Nama Kategori</label>
          <input type="text" name="nama_kategori" class="form-control" required>
        </div>
      </div>
      <div class=" mt-3">
        <a href="<?php echo BASE_URL; ?>/categories" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>