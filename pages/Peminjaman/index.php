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
                <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
                    <div class="alert alert-<?= $_GET['status'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_GET['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
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
                </div>

                <div id="bukuContainer">
                    <div class="row mb-3 buku-row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select buku-select" name="id_buku[]" required>
                                    <option value="" selected disabled>Pilih Buku</option>
                                    <?php
                                    $query = "SELECT * FROM buku WHERE stok > 0";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['id_buku']}'>{$row['nama_buku']} ({$row['stok']} tersedia)</option>";
                                    }
                                    ?>
                                </select>
                                <label>Buku</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="kondisi_pinjam[]" required>
                                    <option value="" selected disabled>Pilih Kondisi</option>
                                    <option value="bagus">Bagus</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                                <label>Kondisi Saat Dipinjam</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control jumlah-buku" name="jumlah[]" min="1" value="1" required>
                                <label>Jumlah</label>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm remove-buku" style="display: none;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-success btn-sm" id="tambahBuku">
                        <i class="fas fa-plus"></i> Tambah Buku
                    </button>
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

                <!-- Add JavaScript for dynamic book selection -->
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const bukuContainer = document.getElementById('bukuContainer');
                    const tambahBukuBtn = document.getElementById('tambahBuku');

                    tambahBukuBtn.addEventListener('click', function() {
                        const bukuRow = document.querySelector('.buku-row').cloneNode(true);
                        bukuRow.querySelector('.buku-select').value = '';
                        bukuRow.querySelector('.jumlah-buku').value = '1';
                        bukuRow.querySelector('.remove-buku').style.display = 'block';
                        bukuContainer.appendChild(bukuRow);

                        // Add event listener to remove button
                        bukuRow.querySelector('.remove-buku').addEventListener('click', function() {
                            bukuRow.remove();
                        });
                    });

                    // Update stock validation
                    bukuContainer.addEventListener('change', function(e) {
                        if (e.target.classList.contains('buku-select') || e.target.classList.contains('jumlah-buku')) {
                            const row = e.target.closest('.buku-row');
                            const select = row.querySelector('.buku-select');
                            const jumlah = row.querySelector('.jumlah-buku');
                            
                            if (select.value) {
                                const option = select.selectedOptions[0];
                                const stok = parseInt(option.text.match(/\((\d+) tersedia\)/)[1]);
                                jumlah.max = stok;
                                
                                if (parseInt(jumlah.value) > stok) {
                                    alert('Jumlah melebihi stok tersedia!');
                                    jumlah.value = stok;
                                }
                            }
                        }
                    });

                    // Add form submission validation
                    document.getElementById('peminjamanForm').addEventListener('submit', function(e) {
                        const bukuSelects = document.querySelectorAll('.buku-select');
                        const selectedBooks = new Set();
                        let isValid = true;

                        bukuSelects.forEach(select => {
                            if (!select.value) {
                                isValid = false;
                                alert('Silahkan pilih buku untuk semua field');
                                e.preventDefault();
                                return;
                            }
                            selectedBooks.add(select.value);
                        });

                        if (!document.getElementById('anggota').value) {
                            isValid = false;
                            alert('Silahkan pilih anggota');
                            e.preventDefault();
                            return;
                        }

                        // Additional validation if needed
                    });
                });
                </script>

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
            
            // Get total records for pagination
            $total_query = "SELECT COUNT(DISTINCT p.kode_pinjam) as total 
                          FROM peminjaman p 
                          WHERE p.status = 'DIPINJAM'";
            $total_result = mysqli_query($conn, $total_query);
            $total_row = mysqli_fetch_assoc($total_result);
            $total_pages = ceil($total_row['total'] / $limit);
            
            // Modified query with pagination and GROUP_CONCAT for multiple books
            $query = "SELECT p.*, 
                     a.nama_anggota, 
                     a.nomor_telp, 
                     a.email,
                     pt.nama_petugas,
                     GROUP_CONCAT(CONCAT(b.nama_buku, ' (', dp.jumlah, ')') SEPARATOR ', ') as nama_buku,
                     GROUP_CONCAT(b.id_buku SEPARATOR ', ') as id_buku,
                     GROUP_CONCAT(dp.jumlah SEPARATOR ', ') as jumlah_buku
                     FROM peminjaman p 
                     JOIN anggota a ON p.id_anggota = a.id_anggota 
                     JOIN petugas pt ON p.id_petugas = pt.id_petugas
                     LEFT JOIN detail_peminjaman dp ON p.kode_pinjam = dp.kode_pinjam
                     LEFT JOIN buku b ON dp.id_buku = b.id_buku
                     WHERE p.status = 'DIPINJAM'
                     GROUP BY p.kode_pinjam
                     ORDER BY p.tanggal_pinjam DESC
                     LIMIT $start, $limit";

            $result = mysqli_query($conn, $query);
            ?>
            <table class="table table-striped table-bordered">
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
                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        $isOverdue = strtotime($row['estimasi_pinjam']) < strtotime(date('Y-m-d'));
                        
                        // Add null checks for books
                        $nama_buku = $row['nama_buku'] ?? '';
                        $books = !empty($nama_buku) ? explode(', ', $nama_buku) : ['Data tidak tersedia'];
                        
                        // Create overdue message with null check
                        $overdueMessage = "Halo {$row['nama_anggota']}, buku " . 
                            (!empty($books) ? implode(', ', $books) : 'yang dipinjam') . 
                            " sudah melewati batas waktu pengembalian. Mohon segera dikembalikan. Terima kasih.";
                        
                        // Calculate overdue days
                        $overdueDays = 0;
                        if($isOverdue) {
                            $overdueDays = floor((strtotime(date('Y-m-d')) - strtotime($row['estimasi_pinjam'])) / (60 * 60 * 24));
                        }
                        
                        echo "<tr class='text-center'>";
                        echo "<td>{$row['kode_pinjam']}</td>";
                        echo "<td>{$row['nama_anggota']}</td>";
                        echo "<td>" . (!empty($nama_buku) ? str_replace('(1)', '', $nama_buku) : 'Data tidak tersedia') . "</td>";
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
                    } ?>
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($page > 1) ? $page - 1 : 1; ?>">&laquo;</a>
                        </li>
                        
                        <?php
                        $startPage = max(1, min($page - 2, $total_pages - 4));
                        $endPage = min($total_pages, max(5, $page + 2));
                        
                        if ($startPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                            if ($startPage > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $startPage; $i <= $endPage; $i++) {
                            echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                                  <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                                </li>';
                        }
                        
                        if ($endPage < $total_pages) {
                            if ($endPage < $total_pages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($page < $total_pages) ? $page + 1 : $total_pages; ?>">&raquo;</a>
                        </li>
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