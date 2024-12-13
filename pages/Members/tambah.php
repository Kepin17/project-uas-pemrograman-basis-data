<?php
require "config/connection.php";
$pageTitle = "Tambah Anggota";
$currentPage = 'members';

function generateIdAnggota($conn) {
    // Query untuk mendapatkan ID anggota dengan nilai numerik terbesar
    $query = "SELECT id_anggota FROM anggota ORDER BY id_anggota DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = $row['id_anggota']; 
        $number = (int) substr($lastId, 2); // Ambil angka setelah 'AG'
        $newNumber = $number + 1;          // Tambah 1
    } else {
        $newNumber = 1; // Jika belum ada data, mulai dari 1
    }

    // Format ID baru
    return 'AG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_telp = $_POST['nomor_telp'];
    $alamat = $_POST['alamat'];

    // Generate ID anggota baru
    $id_anggota = generateIdAnggota($conn);

    // Query untuk insert data
    $query = "INSERT INTO anggota (id_anggota, nama_anggota, email, nomor_telp, alamat) 
              VALUES ('$id_anggota', '$nama', '$email', '$nomor_telp', '$alamat')";

    if ($conn->query($query)) {
        header("Location: " . BASE_URL . "/members?success=menambahkan anggota"); // Redirect ke halaman utama
        exit;
    } else {
        die("Gagal menambahkan anggota: " . $conn->error);
    }
}

ob_start();
?>

<h4 class="mb-3">Tambah Anggota Baru</h4>
<form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" name="nomor_telp" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required></textarea>
        </div>
    </div>
    <div class="text-end mt-3">
        <a href="<?php echo BASE_URL; ?>/members" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
