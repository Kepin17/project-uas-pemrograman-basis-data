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
  $lokasi = $_POST['lokasi'];

  $kode_rak = generateIdRak($conn);

  $query = "INSERT INTO rak_buku (kode_rak, nama_rak, lokasi) VALUES ('$kode_rak', '$nama_rak', '$lokasi')";

  if ($conn->query($query)) {
    header("Location: " . BASE_URL . "/shelves");
    exit;
  } else {
    die("Gagal menambahkan rak: " . $conn->error);
  }
}

ob_start();
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/shelves">Rak Buku</a></li>
    <li class="breadcrumb-item active">Tambah Rak</li>
  </ol>
</nav>

<div class="container-fluid px-4">
  <div class="row">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-transparent border-0 pt-4">
          <h5 class="card-title mb-0">Tambah Rak Buku Baru</h5>
          <p class="text-muted small mb-0">Silakan isi informasi rak buku yang akan ditambahkan</p>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" name="nama_rak" class="form-control" id="namaRak" placeholder="Nama Rak" required>
                  <label for="namaRak">Nama Rak</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <select name="lokasi" class="form-control" id="lokasi" required>
                    <option value="" disabled selected>Pilih Lokasi</option>
                    <option value="Lantai 1">Lantai 1</option>
                    <option value="Lantai 2">Lantai 2</option>
                    <option value="Lantai 3">Lantai 3</option>
                    <option value="Lantai 4">Lantai 4</option>
                    <option value="Lantai 5">Lantai 5</option>
                  </select>
                  <label for="lokasi">Lokasi</label>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
              <a href="<?php echo BASE_URL; ?>/shelves" class="btn btn-light">
                <i class="fas fa-times me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>