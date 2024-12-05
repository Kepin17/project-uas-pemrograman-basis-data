<?php
$pageTitle = "Peminjaman Buku - Perpustakaan";
$currentPage = 'borrowing';

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Peminjaman Buku</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBorrowingModal">
        <i class="fas fa-plus me-2"></i>Peminjaman Baru
    </button>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="Cari peminjam atau buku...">
            </div>
            <div class="col-12 col-md-3">
                <select class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1">Dipinjam</option>
                    <option value="2">Terlambat</option>
                    <option value="3">Dikembalikan</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <input type="date" class="form-control">
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-secondary w-100">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Borrowing Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=John+Doe" class="rounded-circle me-2" width="32">
                                <div>
                                    <div class="fw-bold">John Doe</div>
                                    <small class="text-muted">ID: M001</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/32x48" class="me-2">
                                <div>
                                    <div class="fw-bold">Harry Potter</div>
                                    <small class="text-muted">Rak: A-1</small>
                                </div>
                            </div>
                        </td>
                        <td>2023-12-20</td>
                        <td>2024-01-03</td>
                        <td><span class="badge bg-success">Dipinjam</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="Kembalikan">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=Jane+Smith" class="rounded-circle me-2" width="32">
                                <div>
                                    <div class="fw-bold">Jane Smith</div>
                                    <small class="text-muted">ID: M002</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/32x48" class="me-2">
                                <div>
                                    <div class="fw-bold">Lord of the Rings</div>
                                    <small class="text-muted">Rak: B-2</small>
                                </div>
                            </div>
                        </td>
                        <td>2023-12-15</td>
                        <td>2023-12-29</td>
                        <td><span class="badge bg-warning">Terlambat</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="Kembalikan">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add Borrowing Modal -->
<div class="modal fade" id="addBorrowingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Peminjaman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">ID Anggota</label>
                            <div class="input-group">
                                <input type="text" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Anggota</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ISBN Buku</label>
                            <div class="input-group">
                                <input type="text" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
