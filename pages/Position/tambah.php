<?php
require "config/connection.php";
$pageTitle = "Tambah Jabatan";
$currentPage = 'position';

function generateIdJabatan($conn) {
    $query = "SELECT id_jabatan FROM jabatan ORDER BY id_jabatan DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = $row['id_jabatan']; 
        $number = (int) substr($lastId, 2);
        $newNumber = $number + 1;
    } else {
        $newNumber = 1; 
    }

    return 'JB' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_jabatan = $_POST['nama_jabatan'];

    $id_jabatan = generateIdJabatan($conn);

    $query = "INSERT INTO jabatan (id_jabatan, nama_jabatan) VALUES ('$id_jabatan', '$nama_jabatan')";

    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/position");
        exit;
    } else {
        die("Gagal menambahkan jabatan: " . $conn->error);
    }
}

ob_start();
?>

<h4 class="mb-3">Tambah Jabatan Baru</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Jabatan</label>
            <input type="text" name="nama_jabatan" class="form-control" required>
        </div>
    </div>
    <div class="text-end mt-3">
        <a href="<?php echo BASE_URL; ?>/position" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
