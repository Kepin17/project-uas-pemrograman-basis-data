<?php
require "config/connection.php";

// Check if user is logged in
if (!isset($_SESSION['id_petugas'])) {
    header("Location: login.php");
    exit();
}

// Generate kode_pinjam
$query = "SELECT kode_pinjam FROM peminjaman ORDER BY kode_pinjam DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$nextKode = "PJ001";

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $lastKode = $row['kode_pinjam'];
    $lastNumber = intval(substr($lastKode, 2));
    $nextNumber = $lastNumber + 1;
    $nextKode = 'PJ' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
}

$pageTitle = "Manajemen Peminjaman - Perpustakaan";
$currentPage = 'peminjaman';
ob_start();
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Peminjaman Buku</h1>
  

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-book-reader me-1"></i>
            Form Peminjaman
        </div>
        <div class="card-body">
            <form id="peminjamanForm" action="peminjaman/process" method="POST">
                <!-- Add hidden petugas input -->
                <input type="hidden" name="id_petugas" value="<?php echo $_SESSION['id_petugas']; ?>">
                <input type="hidden" name="kode_pinjam" value="<?php echo $nextKode; ?>">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="kode_pinjam" value="<?php echo $nextKode; ?>" disabled>
                            <label>Kode Peminjaman</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" value="<?php echo $_SESSION['nama_petugas']; ?>" disabled>
                            <label>Petugas</label>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="anggota" name="id_anggota" required>
                                <option value="" selected disabled>Pilih Anggota</option>
                                <?php
                                $query = "SELECT id_anggota, nama_anggota FROM anggota";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['id_anggota']}'>{$row['id_anggota']} - {$row['nama_anggota']}</option>";
                                }
                                ?>
                            </select>
                            <label for="anggota">Anggota</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="buku" name="id_buku" required>
                                <option value="" selected disabled>Pilih Buku</option>
                                <?php
                                $query = "SELECT * FROM buku WHERE stok > 0";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['id_buku']}'>{$row['nama_buku']} ({$row['stok']} tersedia)</option>";
                                }
                                ?>
                            </select>
                            <label for="buku">Buku</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="date" id="tanggal_pinjam" name="tanggal_pinjam" required
                                value="<?php echo date('Y-m-d'); ?>">
                            <label for="tanggal_pinjam">Tanggal Pinjam</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="date" id="estimasi_pinjam" name="estimasi_pinjam" required
                                value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>">
                            <label for="estimasi_pinjam">Tanggal Kembali</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-0">
                    <div class="d-grid">
                        <button class="btn btn-primary btn-block" type="submit">Submit Peminjaman</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Peminjaman Aktif
        </div>
        <div class="card-body">
            <?php
            // Pagination configuration
            $limit = 5;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;
            
            // Get total records
            $total_query = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'Dipinjam'";
            $total_result = mysqli_query($conn, $total_query);
            $total_row = mysqli_fetch_assoc($total_result);
            $total_pages = ceil($total_row['total'] / $limit);
            
            // Modified query with pagination
            $query = "SELECT p.*, a.nama_anggota, a.nomor_telp, a.email, b.nama_buku, pt.nama_petugas 
                     FROM peminjaman p 
                     JOIN anggota a ON p.id_anggota = a.id_anggota 
                     JOIN buku b ON p.id_buku = b.id_buku
                     JOIN petugas pt ON p.id_petugas = pt.id_petugas
                     WHERE p.status = 'Dipinjam'
                     ORDER BY p.tanggal_pinjam DESC
                     LIMIT $start, $limit";
            ?>
            <table id="datatablesSimple" class="table table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th width="8%">ID</th>
                        <th width="15%">Peminjam</th>
                        <th width="15%">Buku</th>
                        <th width="12%">Tanggal Pinjam</th>
                        <th width="12%">Tanggal Kembali</th>
                        <th width="15%">Petugas</th>
                        <th width="10%">Status</th>
                        <th width="13%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $isOverdue = strtotime($row['estimasi_pinjam']) < strtotime(date('Y-m-d'));
                        $overdueMessage = "Halo {$row['nama_anggota']}, buku {$row['nama_buku']} yang Anda pinjam sudah melewati batas waktu pengembalian. Mohon segera dikembalikan. Terima kasih.";
                        
                        // Calculate overdue days
                        $overdueDays = 0;
                        if($isOverdue) {
                            $overdueDays = floor((strtotime(date('Y-m-d')) - strtotime($row['estimasi_pinjam'])) / (60 * 60 * 24));
                        }
                        
                        echo "<tr class='text-center'>";
                        echo "<td>{$row['kode_pinjam']}</td>";
                        echo "<td>{$row['nama_anggota']}</td>";
                        echo "<td>{$row['nama_buku']}</td>";
                        echo "<td>" . date('d/m/Y', strtotime($row['tanggal_pinjam'])) . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($row['estimasi_pinjam'])) . "</td>";
                        echo "<td>{$row['nama_petugas']}</td>";
                        echo "<td>" . ($isOverdue ? 
                            "<span class='badge bg-danger'>Terlambat {$overdueDays} hari</span>" : 
                            "<span class='badge bg-success'>{$row['status']}</span>") . "</td>";
                        echo "<td class='d-flex justify-content-center gap-2'>";
                        
                        if($isOverdue) {
                            // WhatsApp button for overdue
                            $waNumber = preg_replace('/^0/', '62', $row['nomor_telp']);
                            echo "<a href='https://wa.me/{$waNumber}?text=" . urlencode($overdueMessage) . "' 
                            target='_blank' class='btn btn-primary btn-sm mb-1'>
                            <i class='fab fa-whatsapp'></i> WhatsApp
                            </a>";
                            
                            // Email button for overdue
                            echo "<a href='mailto:{$row['email']}?subject=Pengingat Pengembalian Buku&body=" . urlencode($overdueMessage) . "' 
                            class='btn btn-warning btn-sm'>
                            <i class='fas fa-envelope'></i> Email
                            </a>";
                        } else {
                            // Disabled buttons for non-overdue
                            echo "<button class='btn btn-secondary btn-sm mb-1' disabled>
                            <i class='fab fa-whatsapp'></i> WhatsApp
                            </button>";
                            
                            echo "<button class='btn btn-secondary btn-sm' disabled>
                            <i class='fas fa-envelope'></i> Email
                            </button>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page-1 ?>">&laquo; Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page+1 ?>">Next &raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>