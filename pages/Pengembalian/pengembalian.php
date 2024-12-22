<?php
require "config/connection.php";
$pageTitle = "Pengembalian Buku";
$currentPage = "returning";
ob_start();

// Fetch active loans
$query = "SELECT p.kode_pinjam, m.nama_anggota as nama, b.nama_buku as judul 
          FROM peminjaman p 
          JOIN anggota m ON p.id_anggota = m.id_anggota 
          JOIN buku b ON p.id_buku = b.id_buku 
          WHERE p.status = 'dipinjam' || p.status = 'terlambat'
          ORDER BY p.kode_pinjam DESC";
$result = $conn->query($query) or die(mysqli_error($conn));

// Fetch loan details if a peminjam is selected
$detail_peminjaman = null;
if (isset($_POST['peminjaman_id'])) {
    $kode_pinjam = $_POST['peminjaman_id'];
    $query_detail = "SELECT p.*, m.nama_anggota, b.nama_buku,
                     DATEDIFF(CURRENT_DATE, p.estimasi_pinjam) as keterlambatan
                     FROM peminjaman p 
                     JOIN anggota m ON p.id_anggota = m.id_anggota
                     JOIN buku b ON p.id_buku = b.id_buku
                     WHERE p.kode_pinjam = ?";
    
    $stmt = $conn->prepare($query_detail);
    $stmt->bind_param("s", $kode_pinjam);
    $stmt->execute();
    $detail_peminjaman = $stmt->get_result()->fetch_assoc();
    
    // Calculate late fee
    $denda_terlambat = max(0, $detail_peminjaman['keterlambatan']) * 2000;
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengembalian Buku</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form id="returnForm" method="POST">
                        <div class="mb-3">
                            <label for="peminjaman_id" class="form-label">Pilih Peminjam</label>
                            <select class="form-select" id="peminjaman_id" name="peminjaman_id" required onchange="this.form.submit()">
                                <option value="">Pilih Peminjam</option>
                                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?= $row['kode_pinjam'] ?>" <?= (isset($_POST['peminjaman_id']) && $_POST['peminjaman_id'] == $row['kode_pinjam']) ? 'selected' : '' ?>>
                                        <?= $row['kode_pinjam'] ?> - <?= $row['nama'] ?> (<?= $row['judul'] ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kondisi_buku" class="form-label">Kondisi Buku</label>
                            <select class="form-select" id="kondisi_buku" name="kondisi_buku" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="bagus">Bagus (Rp 0)</option>
                                <option value="rusak">Rusak (Rp 100,000)</option>
                                <option value="hilang">Hilang (Rp 500,000)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail Peminjaman</label>
                            <div id="detailPeminjaman" class="border rounded p-3 bg-light">
                                <p class="mb-2">Nama Peminjam: <span><?= $detail_peminjaman ? $detail_peminjaman['nama_anggota'] : '-' ?></span></p>
                                <p class="mb-2">Judul Buku: <span><?= $detail_peminjaman ? $detail_peminjaman['nama_buku'] : '-' ?></span></p>
                                <p class="mb-2">Tanggal Pinjam: <span><?= $detail_peminjaman ? date('d F Y', strtotime($detail_peminjaman['tanggal_pinjam'])) : '-' ?></span></p>
                                <p class="mb-2">Batas Kembali: <span><?= $detail_peminjaman ? date('d F Y', strtotime($detail_peminjaman['estimasi_pinjam'])) : '-' ?></span></p>
                                <p class="mb-2">Keterlambatan: <span><?= $detail_peminjaman ? ($detail_peminjaman['keterlambatan'] > 0 ? $detail_peminjaman['keterlambatan'].' hari' : 'Tidak terlambat') : '-' ?></span></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rincian Biaya</label>
                            <div id="rincianBiaya" class="border rounded p-3 bg-light">
                                <p class="mb-2">Denda Keterlambatan: <span>Rp <?= $detail_peminjaman ? number_format($denda_terlambat, 0, ',', '.') : '0' ?></span></p>
                                <p class="mb-2">Denda Kondisi: <span id="denda_kondisi">Rp 0</span></p>
                                <p class="fw-bold mb-0">Total Denda: <span id="total_denda">Rp <?= $detail_peminjaman ? number_format($denda_terlambat, 0, ',', '.') : '0' ?></span></p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Riwayat Pengembalian</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Kondisi</th>
                                    <th>Total Denda</th>
                                </tr>
                            </thead>
                            <tbody id="riwayatPengembalian">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/pengembalian.js"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/main.php';
?>

