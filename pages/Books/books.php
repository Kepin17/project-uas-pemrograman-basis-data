<?php
$pageTitle = "Manajemen Buku - Perpustakaan";
$currentPage = 'books';

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Manajemen Buku</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
        <i class="fas fa-plus me-2"></i>Tambah Buku
    </button>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="Cari buku...">
            </div>
            <div class="col-12 col-md-3">
                <select class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="1">Fiksi</option>
                    <option value="2">Non-Fiksi</option>
                    <option value="3">Pendidikan</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select class="form-select">
                    <option value="">Semua Rak</option>
                    <option value="1">Rak A</option>
                    <option value="2">Rak B</option>
                    <option value="3">Rak C</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-secondary w-100">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Books Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>ISBN</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Rak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40x60" class="me-2">
                                <div>
                                    <div class="fw-bold">Harry Potter and the Philosopher's Stone</div>
                                    <small class="text-muted">2001</small>
                                </div>
                            </div>
                        </td>
                        <td>978-0-7475-3269-9</td>
                        <td>J.K. Rowling</td>
                        <td>Fiksi</td>
                        <td>Rak A-1</td>
                        <td><span class="badge bg-success">Tersedia</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editBookModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBookModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40x60" class="me-2">
                                <div>
                                    <div class="fw-bold">The Lord of the Rings</div>
                                    <small class="text-muted">1954</small>
                                </div>
                            </div>
                        </td>
                        <td>978-0-618-57498-4</td>
                        <td>J.R.R. Tolkien</td>
                        <td>Fiksi</td>
                        <td>Rak B-2</td>
                        <td><span class="badge bg-warning">Dipinjam</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editBookModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBookModal">
                                    <i class="fas fa-trash"></i>
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

<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <option value="1">Fiksi</option>
                                <option value="2">Non-Fiksi</option>
                                <option value="3">Pendidikan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rak</label>
                            <select class="form-select" required>
                                <option value="">Pilih Rak</option>
                                <option value="1">Rak A-1</option>
                                <option value="2">Rak B-2</option>
                                <option value="3">Rak C-3</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Cover Buku</label>
                            <input type="file" class="form-control">
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

<!-- Edit Book Modal -->
<div class="modal fade" id="editBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Similar form as Add Book Modal but with pre-filled values -->
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" value="Harry Potter and the Philosopher's Stone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control" value="978-0-7475-3269-9" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" value="J.K. Rowling" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" value="2001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" required>
                                <option value="1" selected>Fiksi</option>
                                <option value="2">Non-Fiksi</option>
                                <option value="3">Pendidikan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rak</label>
                            <select class="form-select" required>
                                <option value="1" selected>Rak A-1</option>
                                <option value="2">Rak B-2</option>
                                <option value="3">Rak C-3</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Cover Buku</label>
                            <input type="file" class="form-control">
                            <div class="mt-2">
                                <small class="text-muted">Current cover:</small>
                                <img src="https://via.placeholder.com/100x150" class="ms-2" alt="Current cover">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Book Modal -->
<div class="modal fade" id="deleteBookModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
