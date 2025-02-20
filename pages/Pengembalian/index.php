<?php
require "config/connection.php";
$pageTitle = "Pengembalian Buku";
$currentPage = "returning";
ob_start();

// Fetch active loans with multiple books
$query = "SELECT p.kode_pinjam, 
          a.nama_anggota as nama,
          GROUP_CONCAT(b.nama_buku SEPARATOR ', ') as judul,
          GROUP_CONCAT(b.id_buku SEPARATOR ', ') as id_buku
          FROM peminjaman p 
          JOIN anggota a ON p.id_anggota = a.id_anggota 
          LEFT JOIN detail_peminjaman dp ON p.kode_pinjam = dp.kode_pinjam
          LEFT JOIN buku b ON dp.id_buku = b.id_buku 
          WHERE p.status = 'DIPINJAM' OR p.status = 'TERLAMBAT'
          GROUP BY p.kode_pinjam
          ORDER BY p.kode_pinjam DESC";
$result = $conn->query($query) or die(mysqli_error($conn));

// Fetch loan details if a peminjam is selected
$detail_peminjaman = null;
if (isset($_POST['peminjaman_id'])) {
    $kode_pinjam = $_POST['peminjaman_id'];
    $query_detail = "SELECT p.*, 
                     a.nama_anggota,
                     GROUP_CONCAT(b.nama_buku SEPARATOR ', ') as nama_buku,
                     GROUP_CONCAT(b.id_buku SEPARATOR ', ') as id_buku,
                     DATEDIFF(CURRENT_DATE, p.estimasi_pinjam) as keterlambatan
                     FROM peminjaman p 
                     JOIN anggota a ON p.id_anggota = a.id_anggota
                     LEFT JOIN detail_peminjaman dp ON p.kode_pinjam = dp.kode_pinjam
                     LEFT JOIN buku b ON dp.id_buku = b.id_buku
                     WHERE p.kode_pinjam = ?
                     GROUP BY p.kode_pinjam";
    
    $stmt = $conn->prepare($query_detail);
    $stmt->bind_param("s", $kode_pinjam);
    $stmt->execute();
    $detail_peminjaman = $stmt->get_result()->fetch_assoc();
    
    // Calculate late fee
    $denda_terlambat = max(0, $detail_peminjaman['keterlambatan']) * 5000;

    $denda_kondisi = [
        'bagus' => 0,
        'rusak' => 100000,
        'hilang' => 500000
    ];
}

// Define denda_kondisi and denda_per_hari globally
$denda_kondisi = [
    'bagus' => 0,
    'rusak' => 100000,
    'hilang' => 500000
];
$denda_per_hari = 5000;
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengembalian Buku</h1>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form id="returnForm" method="POST" action="returning/pross">
            <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
                    <div class="alert alert-<?= $_GET['status'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_GET['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="peminjaman_id" class="form-label">Pilih Peminjam</label>
                            <select class="form-select" id="peminjaman_id" name="peminjaman_id" required>
                                <option value="">Pilih Peminjam</option>
                                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?= $row['kode_pinjam'] ?>" <?= (isset($_POST['peminjaman_id']) && $_POST['peminjaman_id'] == $row['kode_pinjam']) ? 'selected' : '' ?>>
                                        <?= $row['kode_pinjam'] ?> - <?= $row['nama'] ?> (<?= $row['judul'] ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kondisi_buku" class="form-label">Kondisi Buku</label>
                            <select class="form-select" id="kondisi_buku" name="kondisi_buku" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="bagus">Bagus (Rp 0)</option>
                                <option value="rusak">Rusak (Rp 100,000)</option>
                                <option value="hilang">Hilang (Rp 500,000)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
            </form>
        </div>
    </div>

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
                            <th>Status</th>
                            <th>Total Denda</th>
                        </tr>
                    </thead>
                    <tbody id="riwayatPengembalian">
                        <?php
                        // Pagination configuration
                        $records_per_page = 5;
                        $total_query = "SELECT COUNT(*) as total FROM pengembalian";
                        $total_result = $conn->query($total_query);
                        $total_records = $total_result->fetch_assoc()['total'];
                        $total_pages = max(1, ceil($total_records / $records_per_page));

                        // Validate and sanitize page number
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $page = max(1, min($page, $total_pages)); // Ensure page is between 1 and total_pages
                        $offset = ($page - 1) * $records_per_page;

                        // Modified query for history with proper GROUP BY
                        $query = "SELECT 
                                    pb.kode_pengembalian,
                                    pb.kode_pinjam,
                                    pb.tanggal_pengembalian,
                                    pb.kondisi_buku,
                                    pb.denda,
                                    a.nama_anggota,
                                    GROUP_CONCAT(DISTINCT b.nama_buku SEPARATOR ', ') as nama_buku,
                                    DATEDIFF(pb.tanggal_pengembalian, p.estimasi_pinjam) as hari_terlambat,
                                    CASE 
                                        WHEN DATEDIFF(pb.tanggal_pengembalian, p.estimasi_pinjam) > 0 
                                        THEN DATEDIFF(pb.tanggal_pengembalian, p.estimasi_pinjam) * $denda_per_hari 
                                        ELSE 0 
                                    END as denda_terlambat
                                  FROM pengembalian pb
                                  JOIN peminjaman p ON pb.kode_pinjam = p.kode_pinjam
                                  JOIN anggota a ON p.id_anggota = a.id_anggota
                                  LEFT JOIN detail_peminjaman dp ON p.kode_pinjam = dp.kode_pinjam
                                  LEFT JOIN buku b ON dp.id_buku = b.id_buku
                                  GROUP BY pb.kode_pengembalian, 
                                           pb.kode_pinjam,
                                           pb.tanggal_pengembalian,
                                           pb.kondisi_buku,
                                           pb.denda,
                                           a.nama_anggota,
                                           p.estimasi_pinjam
                                  ORDER BY pb.tanggal_pengembalian DESC
                                  LIMIT ?, ?";

                        // Use prepared statement for the pagination query
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ii", $offset, $records_per_page);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            $nama_buku = $row['nama_buku'] ?? 'Data tidak tersedia';
                            $denda = $denda_kondisi[$row['kondisi_buku']];
                            $total_denda = $row['denda'];
                            $status = $row['hari_terlambat'] > 0 
                                ? "<span class='text-danger'>Terlambat ({$row['hari_terlambat']} hari)</span>" 
                                : "<span class='text-success'>Tepat Waktu</span>";
                        ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($row['tanggal_pengembalian'])) ?></td>
                                <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                                <td><?= htmlspecialchars($nama_buku) ?></td>
                                <td><?= ucfirst($row['kondisi_buku']) ?></td>
                                <td><?= $status ?></td>
                                <td>Rp <?= number_format($row['denda'], 0, ',', '.') ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>" <?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Previous</a>
                    </li>
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>" <?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle status messages from URL parameters
    <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
        <?php if ($_GET['status'] === 'error'): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= htmlspecialchars($_GET['message']) ?>',
                confirmButtonColor: '#dc3545'
            });
        <?php elseif ($_GET['status'] === 'success'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= htmlspecialchars($_GET['message']) ?>',
                confirmButtonColor: '#28a745'
            });
        <?php endif; ?>
    <?php endif; ?>
</script>

<script src="<?= BASE_URL ?>/assets/js/pengembalian.js"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/main.php';
?>
