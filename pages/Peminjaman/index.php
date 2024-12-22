<?php
require_once(__DIR__ . '/../../config/connection.php');

$pageTitle = "Peminjaman Buku";
$currentPage = 'peminjaman';

// Get next PJ code
$query = "SELECT MAX(CAST(SUBSTRING(kode_pinjam, 3) AS SIGNED)) as max_id FROM peminjaman";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$next_id = str_pad(($row['max_id'] + 1), 3, '0', STR_PAD_LEFT);
$next_pj_code = 'PJ' . $next_id;

// Pagination configuration
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Get total records for pagination
$total_records_query = "SELECT COUNT(*) as total FROM peminjaman";
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];
$total_pages = ceil($total_records / $records_per_page);

// Modify the main query to include pagination
$query = "SELECT p.*, 
        a.nama_anggota,
        a.nomor_telp,                                                                                             
        a.email,
        GROUP_CONCAT(b.nama_buku SEPARATOR ', ') as buku_dipinjam,
        pet.nama_petugas
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id_anggota
    JOIN detail_peminjaman dp ON p.kode_pinjam = dp.kode_pinjam
    JOIN buku b ON dp.id_buku = b.id_buku
    JOIN petugas pet ON p.id_petugas = pet.id_petugas
    GROUP BY p.kode_pinjam
    ORDER BY p.tanggal_pinjam DESC
    LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $offset, $records_per_page);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

ob_start();
?>

<style>
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .action-buttons .btn {
        margin: 0; /* Remove default button margins */
    }
    .selected-book {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 8px;
        border: 1px solid #dee2e6;
    }
    .book-count-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
    }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Peminjaman Buku</h1>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Daftar Peminjaman
        </div>
        <div class="card-body">
            <!-- Move button here -->
            <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrowingModal">
                    <i class="fas fa-plus"></i> Peminjaman Baru
                </button>
            </div>
            
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Estimasi Kembali</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)):
                        // Calculate if overdue
                        $estimasi = new DateTime($row['estimasi_pinjam']);
                        $today = new DateTime();
                        $isOverdue = $today > $estimasi && $row['status'] == 'DIPINJAM';
                        
                        if ($isOverdue) {
                            // Update status to TERLAMBAT if overdue
                            $updateQuery = "UPDATE peminjaman SET status = 'TERLAMBAT' 
                                          WHERE kode_pinjam = '{$row['kode_pinjam']}'";
                            mysqli_query($conn, $updateQuery);
                            $row['status'] = 'TERLAMBAT';
                        }
                    ?>
                    <tr>
                        <td><?= $row['kode_pinjam'] ?></td>
                        <td><?= $row['nama_anggota'] ?></td>
                        <td><?= $row['buku_dipinjam'] ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['estimasi_pinjam'])) ?></td>
                        <td>
                            <?php
                            switch ($row['status']) {
                                case 'DIPINJAM':
                                    echo '<span class="badge bg-primary">Dipinjam</span>';
                                    break;
                                case 'TERLAMBAT':
                                    echo '<span class="badge bg-danger">Terlambat</span>';
                                    break;
                                case 'DIKEMBALIKAN':
                                    echo '<span class="badge bg-success">Dikembalikan</span>';
                                    break;
                            }
                            ?>
                        </td>
                        <td><?= $row['nama_petugas'] ?></td>
                        <td>
                            <?php if ($row['status'] != 'DIKEMBALIKAN'): ?>
                                <div class="action-buttons">
                                    <!-- WhatsApp Button -->
                                    <a href="https://wa.me/<?= preg_replace('/^0/', '62', $row['nomor_telp']) ?>?text=<?= urlencode(
                                        "Halo {$row['nama_anggota']}, \n".
                                        "Ini reminder untuk peminjaman buku: \n".
                                        "- {$row['buku_dipinjam']} \n".
                                        "Tanggal kembali: " . date('d/m/Y', strtotime($row['estimasi_pinjam'])) . "\n".
                                        "Mohon dikembalikan tepat waktu. Terima kasih!"
                                    ) ?>" 
                                       class="btn btn-success btn-sm" 
                                       target="_blank">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                    
                                    <!-- Email Button -->
                                    <a href="mailto:<?= $row['email'] ?>?subject=<?= urlencode(
                                        "Reminder Peminjaman Buku"
                                    ) ?>&body=<?= urlencode(
                                        "Halo {$row['nama_anggota']}, \n\n".
                                        "Ini reminder untuk peminjaman buku: \n".
                                        "- {$row['buku_dipinjam']} \n\n".
                                        "Tanggal kembali: " . date('d/m/Y', strtotime($row['estimasi_pinjam'])) . "\n\n".
                                        "Mohon dikembalikan tepat waktu. Terima kasih!"
                                    ) ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-envelope"></i> Email
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- Add this inside the card-body, after the table -->
            <div class="mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($total_pages > 1): ?>
                            <!-- First Page -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=1" <?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            </li>
                            
                            <!-- Previous Page -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" <?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            
                            <?php
                            // Calculate range of page numbers to show
                            $range = 2;
                            $start_page = max(1, $page - $range);
                            $end_page = min($total_pages, $page + $range);
                            
                            // Show page numbers
                            for ($i = $start_page; $i <= $end_page; $i++):
                            ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <!-- Next Page -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>" <?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                            
                            <!-- Last Page -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $total_pages ?>" <?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <div class="text-center text-muted">
                    Showing <?= ($offset + 1) ?>-<?= min($offset + $records_per_page, $total_records) ?> of <?= $total_records ?> records
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Borrowing Modal -->
<div class="modal fade" id="borrowingModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-book-reader me-2"></i>Peminjaman Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="borrowingForm" action="<?= BASE_URL ?>/peminjaman/process.php" method="POST">
                    <input type="hidden" name="kode_pinjam" value="<?= $next_pj_code ?>">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-4">
                            <!-- Borrowing Details Card -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Detail Peminjaman</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Kode Peminjaman</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                            <input type="text" class="form-control" value="<?= $next_pj_code ?>" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Pilih Anggota</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <select class="form-select select2" name="id_anggota" required>
                                                <option value="">Pilih Anggota</option>
                                                <?php
                                                $query = "SELECT id_anggota, nama_anggota, nomor_telp FROM anggota ORDER BY nama_anggota";
                                                $result = mysqli_query($conn, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='{$row['id_anggota']}' data-phone='{$row['nomor_telp']}'>";
                                                    echo "{$row['nama_anggota']} ({$row['id_anggota']})";
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div id="memberInfo" class="small mt-2 d-none">
                                            <span class="text-muted">Nomor Telepon: </span>
                                            <span id="memberPhone"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Tanggal Peminjaman</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" class="form-control" name="tanggal_pinjam" 
                                                   value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Estimasi Pengembalian</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                            <input type="date" class="form-control" name="estimasi_pinjam" 
                                                   value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
                                        </div>
                                        <div class="form-text">Maksimal peminjaman 7 hari</div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            

                            <!-- Selected Books Card -->
                            <div class="card shadow-sm mt-3">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0"></h6>
                                        <i class="fas fa-shopping-cart me-2"></i>Keranjang Buku
                                        <small class="text-muted">(Maks. 3 Buku)</small>
                                    </h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary" id="selectedCount">0</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="clearCart">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="selectedBooks" class="list-group list-group-flush">
                                        <!-- Selected books will appear here -->
                                    </div>
                                    <div id="emptyCart" class="text-center p-3">
                                        <i class="fas fa-shopping-cart text-muted mb-2 fa-2x"></i>
                                        <p class="text-muted mb-0">Keranjang kosong</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column - Book Selection -->
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-books me-2"></i>Pilih Buku
                                        </h6>
                                        <div class="input-group input-group-sm w-50">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control" id="searchBook" placeholder="Cari buku...">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3" id="bookList">
                                        <?php
                                        $query = "SELECT b.*, kb.nama_kategori 
                                                 FROM buku b
                                                 JOIN kategori_buku kb ON b.id_kategori = kb.id_kategori
                                                 WHERE b.stok > 0
                                                 ORDER BY b.nama_buku";
                                        $result = mysqli_query($conn, $query);
                                        while ($book = mysqli_fetch_assoc($result)): ?>
                                            <div class="col-md-6 book-item">
                                                <div class="card h-100 book-card">
                                                    <div class="card-body">
                                                        <h6 class="card-title"><?= $book['nama_buku'] ?></h6>
                                                        <p class="card-text small mb-3">
                                                            <i class="fas fa-user text-muted"></i> <?= $book['nama_penulis'] ?><br>
                                                            <i class="fas fa-tag text-muted"></i> <?= $book['nama_kategori'] ?><br>
                                                            <i class="fas fa-boxes text-muted"></i> Stok: 
                                                            <span class="badge bg-<?= $book['stok'] > 5 ? 'success' : 'warning' ?> stock-display">
                                                                <?= $book['stok'] ?>
                                                            </span>
                                                        </p>
                                                        <button type="button" class="btn btn-primary btn-sm w-100 add-book" 
                                                                data-id="<?= $book['id_buku'] ?>"
                                                                data-name="<?= $book['nama_buku'] ?>"
                                                                data-stock="<?= $book['stok'] ?>">
                                                            <i class="fas fa-plus"></i> Tambah ke Keranjang
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="submit" form="borrowingForm" class="btn btn-primary" id="submitBtn" >
                    <i class="fas fa-save me-1"></i>Proses Peminjaman
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#borrowingModal')
    });

    let selectedBooks = new Map();
    const maxBooks = 3;

    // Enhanced member selection
    $('.select2').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const phone = selectedOption.data('phone');
        if (phone) {
            $('#memberPhone').text(phone);
            $('#memberInfo').removeClass('d-none');
        } else {
            $('#memberInfo').addClass('d-none');
        }
        validateForm();
    });

    // Enhanced book addition
    $('.add-book').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const stock = $(this).data('stock');
        const qty = parseInt($(this).siblings('input[type="number"]').val());

        if (selectedBooks.size >= maxBooks) {
            showAlert('warning', `Maksimal ${maxBooks} buku yang dapat dipinjam`);
            return;
        }

        if (selectedBooks.has(id)) {
            showAlert('warning', 'Buku ini sudah dipilih!');
            return;
        }

        selectedBooks.set(id, {name, qty});
        updateSelectedBooks();
        validateForm();
    });

    function updateSelectedBooks() {
        $.ajax({
            url: '<?= BASE_URL ?>/peminjaman/get_selected_books.php',
            type: 'POST',
            data: {
                books: JSON.stringify(Array.from(selectedBooks.entries()).reduce((obj, [key, value]) => {
                    obj[key] = value;
                    return obj;
                }, {}))
            },
            success: function(response) {
                $('#selectedBooks').html(response);
                $('#selectedCount').text(selectedBooks.size);
                validateForm();
            }
        });
    }

    function validateForm() {
        const isValid = selectedBooks.size > 0 && 
                       $('select[name="id_anggota"]').val() && 
                       $('input[name="tanggal_pinjam"]').val() && 
                       $('input[name="estimasi_pinjam"]').val();
        
        $('#submitBtn').prop('disabled', !isValid);
    }

    function showAlert(type, message) {
        const alertDiv = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('.modal-body').prepend(alertDiv);
        setTimeout(() => alertDiv.alert('close'), 3000);
    }

    // ... rest of existing event handlers ...
});

$(document).ready(function() {
    // ...existing select2 initialization...

    let selectedBooks = new Map();
    const maxBooks = 3;

    // Search functionality
    $('#searchBook').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.book-item').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(searchTerm));
        });
    });

    // Add book to cart
    $('.add-book').click(function() {
        const bookCard = $(this).closest('.book-card');
        const id = $(this).data('id');
        const name = $(this).data('name');
        const stockSpan = bookCard.find('.stock-display');
        const currentStock = parseInt(stockSpan.text());
        const qty = parseInt(bookCard.find('.qty-input').val());

        if (qty < 1 || qty > currentStock) {
            showAlert('warning', 'Jumlah tidak valid');
            return;
        }

        if (selectedBooks.size >= maxBooks) {
            showAlert('warning', `Maksimal ${maxBooks} buku yang dapat dipinjam`);
            return;
        }

        if (selectedBooks.has(id)) {
            showAlert('warning', 'Buku ini sudah ada di keranjang');
            return;
        }

        // Update stock display
        const remainingStock = currentStock - qty;
        stockSpan.text(remainingStock);
        if (remainingStock <= 5) {
            stockSpan.removeClass('bg-success').addClass('bg-warning');
        }

        // Add to cart
        selectedBooks.set(id, {
            name: name,
            qty: qty,
            stock: currentStock,
            remainingStock: remainingStock
        });

        updateCart();
        validateForm();
        showAlert('success', 'Buku ditambahkan ke keranjang');

        // Disable add button if no stock left
        if (remainingStock === 0) {
            $(this).prop('disabled', true);
            bookCard.find('.qty-input').prop('disabled', true);
        }
    });

    // Remove book from cart
    $(document).on('click', '.remove-book', function() {
        const id = $(this).data('id');
        const book = selectedBooks.get(id);
        
        if (confirm(`Hapus buku "${book.name}" dari keranjang?`)) {
            // Restore stock display
            const bookCard = $(`.add-book[data-id="${id}"]`).closest('.book-card');
            const stockSpan = bookCard.find('.stock-display');
            stockSpan.text(book.stock);
            if (book.stock > 5) {
                stockSpan.removeClass('bg-warning').addClass('bg-success');
            }

            // Re-enable controls
            bookCard.find('.add-book').prop('disabled', false);
            bookCard.find('.qty-input').prop('disabled', false)
                   .val(1);

            selectedBooks.delete(id);
            updateCart();
            validateForm();
            showAlert('info', 'Buku dihapus dari keranjang');
        }
    });

    // Clear entire cart
    $('#clearCart').click(function() {
        if (selectedBooks.size === 0) return;
        
        if (confirm('Hapus semua buku dari keranjang?')) {
            // Restore all stocks
            selectedBooks.forEach((book, id) => {
                const bookCard = $(`.add-book[data-id="${id}"]`).closest('.book-card');
                const stockSpan = bookCard.find('.stock-display');
                stockSpan.text(book.stock);
                if (book.stock > 5) {
                    stockSpan.removeClass('bg-warning').addClass('bg-success');
                }
                bookCard.find('.add-book').prop('disabled', false);
                bookCard.find('.qty-input').prop('disabled', false)
                       .val(1);
            });

            selectedBooks.clear();
            updateCart();
            validateForm();
            showAlert('info', 'Keranjang dikosongkan');
        }
    });

    // Update cart display
    function updateCart() {
        const container = $('#selectedBooks');
        const emptyCart = $('#emptyCart');
        container.empty();
        $('#selectedCount').text(selectedBooks.size);

        if (selectedBooks.size === 0) {
            emptyCart.show();
            return;
        }

        emptyCart.hide();
        selectedBooks.forEach((book, id) => {
            container.append(`
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">${book.name}</div>
                            <div class="text-muted small">
                                <span class="me-2">Jumlah: ${book.qty}</span>
                                <span>Sisa Stok: ${book.remainingStock}</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-book" data-id="${id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" name="books[${id}]" value="${book.qty}">
                </div>
            `);
        });
    }

    // Quantity adjustment in cart
    $(document).on('click', '.adjust-qty', function() {
        const id = $(this).data('id');
        const action = $(this).data('action');
        const book = selectedBooks.get(id);
        
        if (action === 'increase' && book.qty < book.stock) {
            book.qty++;
        } else if (action === 'decrease' && book.qty > 1) {
            book.qty--;
        }
        
        selectedBooks.set(id, book);
        updateCart();
    });

    // Validate form before submission
    function validateForm() {
        const isValid = selectedBooks.size > 0 && 
                       $('select[name="id_anggota"]').val() && 
                       $('input[name="tanggal_pinjam"]').val() && 
                       $('input[name="estimasi_pinjam"]').val();
        
        $('#submitBtn').prop('disabled', !isValid);
    }

    // Show alert messages
    function showAlert(type, message) {
        const alertDiv = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('.modal-body').prepend(alertDiv);
        setTimeout(() => alertDiv.alert('close'), 2000);
    }

    // Add form submission handler
    $('#borrowingForm').on('submit', function(e) {
        e.preventDefault();
        
        if (selectedBooks.size === 0) {
            showAlert('warning', 'Pilih minimal satu buku!');
            return false;
        }
        
        // Confirm submission
        if (confirm('Apakah Anda yakin ingin memproses peminjaman ini?')) {
            // Show loading state
            $('#submitBtn').prop('disabled', true)
                          .html('<i class="fas fa-spinner fa-spin me-1"></i>Memproses...');
            
            // Submit the form
            this.submit();
        }
    });

    // Quantity input handling for book selection
    $('.decrease-qty').click(function() {
        const input = $(this).siblings('.qty-input');
        const currentVal = parseInt(input.val());
        if (currentVal > 1) {
            input.val(currentVal - 1);
        }
    });

    $('.increase-qty').click(function() {
        const input = $(this).siblings('.qty-input');
        const currentVal = parseInt(input.val());
        const maxStock = parseInt(input.data('stock'));
        if (currentVal < maxStock) {
            input.val(currentVal + 1);
        }
    });

    $('.qty-input').on('change', function() {
        const val = parseInt($(this).val());
        const max = parseInt($(this).data('stock'));
        if (val < 1) $(this).val(1);
        if (val > max) $(this).val(max);
    });

    // Enhanced book addition with stock management
    $('.add-book').click(function() {
        const bookCard = $(this).closest('.book-card');
        const id = $(this).data('id');
        const name = $(this).data('name');
        const stockSpan = bookCard.find('.stock-display');
        const currentStock = parseInt(stockSpan.text());
        const qty = parseInt(bookCard.find('.qty-input').val());

        if (qty < 1 || qty > currentStock) {
            showAlert('warning', 'Jumlah tidak valid');
            return;
        }

        if (selectedBooks.size >= maxBooks) {
            showAlert('warning', `Maksimal ${maxBooks} buku yang dapat dipinjam`);
            return;
        }

        if (selectedBooks.has(id)) {
            showAlert('warning', 'Buku ini sudah ada di keranjang');
            return;
        }

        // Update stock display
        const remainingStock = currentStock - qty;
        stockSpan.text(remainingStock);
        if (remainingStock <= 5) {
            stockSpan.removeClass('bg-success').addClass('bg-warning');
        }

        // Add to cart
        selectedBooks.set(id, {
            name: name,
            qty: qty,
            stock: currentStock,
            remainingStock: remainingStock
        });

        updateCart();
        validateForm();
        showAlert('success', 'Buku ditambahkan ke keranjang');

        // Disable add button if no stock left
        if (remainingStock === 0) {
            $(this).prop('disabled', true);
            bookCard.find('.qty-input').prop('disabled', true);
        }
    });

    // Enhanced remove from cart with stock restoration
    $(document).on('click', '.remove-book', function() {
        const id = $(this).data('id');
        const book = selectedBooks.get(id);
        
        if (confirm(`Hapus buku "${book.name}" dari keranjang?`)) {
            // Restore stock display
            const bookCard = $(`.add-book[data-id="${id}"]`).closest('.book-card');
            const stockSpan = bookCard.find('.stock-display');
            const addButton = bookCard.find('.add-book');
            
            stockSpan.text(book.stock);
            if (book.stock > 5) {
                stockSpan.removeClass('bg-warning').addClass('bg-success');
            }
            
            addButton.prop('disabled', false);
            
            selectedBooks.delete(id);
            updateCart();
            validateForm();
            showAlert('info', 'Buku dihapus dari keranjang');
        }
    });

    // Enhanced clear cart with stock restoration
    $('#clearCart').click(function() {
        if (selectedBooks.size === 0) return;
        
        if (confirm('Hapus semua buku dari keranjang?')) {
            // Restore all stocks
            selectedBooks.forEach((book, id) => {
                const bookCard = $(`.add-book[data-id="${id}"]`).closest('.book-card');
                const stockSpan = bookCard.find('.stock-display');
                stockSpan.text(book.stock);
                if (book.stock > 5) {
                    stockSpan.removeClass('bg-warning').addClass('bg-success');
                }
                bookCard.find('.add-book').prop('disabled', false);
                bookCard.find('.qty-input').prop('disabled', false)
                       .val(1);
            });

            selectedBooks.clear();
            updateCart();
            validateForm();
            showAlert('info', 'Keranjang dikosongkan');
        }
    });

    // Update the cart display function
    function updateCart() {
        const container = $('#selectedBooks');
        const emptyCart = $('#emptyCart');
        container.empty();
        $('#selectedCount').text(selectedBooks.size);

        if (selectedBooks.size === 0) {
            emptyCart.show();
            return;
        }

        emptyCart.hide();
        selectedBooks.forEach((book, id) => {
            container.append(`
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">${book.name}</div>
                            <div class="text-muted small">
                                <span class="me-2">Jumlah: ${book.qty}</span>
                                <span>Sisa Stok: ${book.remainingStock}</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-book" data-id="${id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" name="books[${id}]" value="${book.qty}">
                </div>
            `);
        });
    }
});
</script>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
