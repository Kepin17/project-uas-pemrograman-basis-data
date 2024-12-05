<?php
$pageTitle = "Pengembalian Buku";
$currentPage = "returning";
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengembalian Buku</h1>
    </div>

    <!-- Form Pengembalian -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form id="returnForm">
                        <div class="mb-3">
                            <label for="peminjaman_id" class="form-label">Pilih Peminjam</label>
                            <select class="form-select" id="peminjaman_id" name="peminjaman_id" required>
                                <option value="">Pilih Peminjam</option>
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
                                <p class="mb-2">Nama Peminjam: <span id="detail_nama">-</span></p>
                                <p class="mb-2">Judul Buku: <span id="detail_buku">-</span></p>
                                <p class="mb-2">Tanggal Pinjam: <span id="detail_tgl_pinjam">-</span></p>
                                <p class="mb-2">Batas Kembali: <span id="detail_batas_kembali">-</span></p>
                                <p class="mb-2">Keterlambatan: <span id="detail_terlambat">-</span></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rincian Biaya</label>
                            <div id="rincianBiaya" class="border rounded p-3 bg-light">
                                <p class="mb-2">Denda Keterlambatan: <span id="denda_terlambat">Rp 0</span></p>
                                <p class="mb-2">Denda Kondisi: <span id="denda_kondisi">Rp 0</span></p>
                                <p class="fw-bold mb-0">Total Denda: <span id="total_denda">Rp 0</span></p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Riwayat Pengembalian -->
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
                                <!-- Data riwayat akan ditampilkan di sini -->
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
