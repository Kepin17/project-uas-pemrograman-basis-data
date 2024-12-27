<?php
require "config/connection.php";
$pageTitle = "peminjaman Baru";
$currentPage = 'borrowing';

function generateKodePinjam($conn)
{
    $query = "SELECT kode_pinjam FROM peminjaman ORDER BY kode_pinjam DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = $row['kode_pinjam'];
        $number = (int) substr($lastId, 2);
        $newNumber = $number + 1;
    } else {
        $newNumber = 1;
    }

    return 'PJ' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_telp = $_POST['nomor_telp'];
    $alamat = $_POST['alamat'];

    $id_anggota = generateIdAnggota($conn);

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

<div class="modal fade" id="modalPeminjamanBaru" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <h5 class="modal-title">Peminjaman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">Pilih Anggota</option>
                            <?php
                            $query = "SELECT id_anggota, nama_anggota FROM anggota";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id_anggota']}'>{$row['nama_anggota']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Buku</label>
                        <select name="id_buku" class="form-select" required>
                            <option value="">Pilih Buku</option>
                            <?php
                            $query = "SELECT id_buku, nama_buku, stok FROM buku WHERE stok > 0";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id_buku']}'>{$row['nama_buku']} | sisa : {$row['stok']} </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estimasi Pengembalian</label>
                        <input type="date" name="estimasi_pinjam" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <a href="<?php echo BASE_URL; ?>/borrowing" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>