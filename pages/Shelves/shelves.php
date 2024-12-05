<?php
$pageTitle = "Rak Buku - Perpustakaan";
$currentPage = 'shelves';

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Rak Buku</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShelfModal">
        <i class="fas fa-plus me-2"></i>Tambah Rak
    </button>
</div>

<!-- Shelves Grid -->
<div class="row g-4">
    <!-- Shelf Card -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Rak A-1</h5>
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editShelfModal">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a></li>
                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteShelfModal">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: 70%"></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <small class="text-muted">Kapasitas</small>
                        <div>35/50 Buku</div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Status</small>
                        <div><span class="badge bg-success">Tersedia</span></div>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Kategori</small>
                    <div>Fiksi</div>
                </div>
                <div>
                    <small class="text-muted">Lokasi</small>
                    <div>Lantai 1, Ruang Utama</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shelf Card -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Rak B-2</h5>
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editShelfModal">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a></li>
                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteShelfModal">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" style="width: 90%"></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <small class="text-muted">Kapasitas</small>
                        <div>45/50 Buku</div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Status</small>
                        <div><span class="badge bg-warning">Hampir Penuh</span></div>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Kategori</small>
                    <div>Non-Fiksi</div>
                </div>
                <div>
                    <small class="text-muted">Lokasi</small>
                    <div>Lantai 1, Ruang Utama</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shelf Card -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Rak C-3</h5>
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editShelfModal">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a></li>
                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteShelfModal">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-danger" style="width: 100%"></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <small class="text-muted">Kapasitas</small>
                        <div>50/50 Buku</div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Status</small>
                        <div><span class="badge bg-danger">Penuh</span></div>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Kategori</small>
                    <div>Pendidikan</div>
                </div>
                <div>
                    <small class="text-muted">Lokasi</small>
                    <div>Lantai 1, Ruang Utama</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Shelf Modal -->
<div class="modal fade" id="addShelfModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rak Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Kode Rak</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option value="">Pilih Kategori</option>
                            <option value="1">Fiksi</option>
                            <option value="2">Non-Fiksi</option>
                            <option value="3">Pendidikan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" required>
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

<!-- Edit Shelf Modal -->
<div class="modal fade" id="editShelfModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Rak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Kode Rak</label>
                        <input type="text" class="form-control" value="A-1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" value="50" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option value="1" selected>Fiksi</option>
                            <option value="2">Non-Fiksi</option>
                            <option value="3">Pendidikan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" value="Lantai 1, Ruang Utama" required>
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

<!-- Delete Shelf Modal -->
<div class="modal fade" id="deleteShelfModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus rak ini? Pastikan rak sudah kosong sebelum menghapus.</p>
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
