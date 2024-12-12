<?php
require "config/connection.php";
$pageTitle = "Tambah Staff";
$currentPage = 'staff';

function generateIdAnggota($conn) {
    $query = "SELECT id_petugas FROM petugas ORDER BY id_petugas DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = $row['id_petugas']; 
        $number = (int) substr($lastId, 2);
        $newNumber = $number + 1;
    } else {
        $newNumber = 1; 
    }

    return 'PG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

$jabatanQuery = "SELECT id_jabatan, nama_jabatan FROM jabatan";
$jabatanResult = $conn->query($jabatanQuery) or die(mysqli_error($conn));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_petugas'];
    $email = $_POST['email'];
    $nomor_telp = $_POST['nomor_telp'];

    $id_anggota = generateIdAnggota($conn);

    $query = "INSERT INTO petugas (id_petugas, nama_petugas, email, nomor_telp) 
              VALUES ('$id_anggota', '$nama', '$email', '$nomor_telp')";

    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/staff");
        exit;
    } else {
        die("Gagal menambahkan staff: " . $conn->error);
    }
}

ob_start();
?>

<h4 class="mb-3">Tambah Staff Baru</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_petugas" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" name="nomor_telp" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="">Jabatan</label>
          <select name="id_jabatan" id="id_jabatan" class="form-select" required>
            <option value="" disabled selected>Pilih Jabatan</option>
            <?php while ($jabatan = $jabatanResult->fetch_assoc()): ?>
              <option value="<?= htmlspecialchars($jabatan['id_jabatan']) ?>">
                <?= htmlspecialchars($jabatan['nama_jabatan'])?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
    </div>
    <div class="text-end mt-3">
        <a href="<?php echo BASE_URL; ?>/staff" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
