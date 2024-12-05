<?php
$pageTitle = "Rak Buku - Perpustakaan";
$currentPage = 'shelves';

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Rak Buku</h4>
    <div class="btn-group">
        <button class="btn btn-primary" onclick="showForm('list')">
            <i class="fas fa-list me-2"></i>List Rak
        </button>
        <button class="btn btn-success" onclick="showForm('add')">
            <i class="fas fa-plus me-2"></i>Tambah Rak
        </button>
    </div>
</div>

<!-- List View -->
<div id="listView">
    <!-- Shelves Grid -->
    <div class="row g-4">
        <!-- Shelf Card -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Rak A-1</h5>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" onclick="showForm('view', 'A-1')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="showForm('edit', 'A-1')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="showForm('delete', 'A-1')">
                                <i class="fas fa-trash"></i>
                            </button>
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
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" onclick="showForm('view', 'B-2')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="showForm('edit', 'B-2')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="showForm('delete', 'B-2')">
                                <i class="fas fa-trash"></i>
                            </button>
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
    </div>
</div>

<!-- View Form -->
<div id="viewForm" class="card" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">Detail Rak</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Kode Rak</label>
                <p>A-1</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Kategori</label>
                <p>Fiksi</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Kapasitas</label>
                <p>50 Buku</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Terisi</label>
                <p>35 Buku</p>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Lokasi</label>
                <p>Lantai 1, Ruang Utama</p>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Status</label>
                <p><span class="badge bg-success">Tersedia</span></p>
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-secondary" onclick="showForm('list')">Kembali</button>
        </div>
    </div>
</div>

<!-- Add Form -->
<div id="addForm" class="card" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">Tambah Rak Baru</h5>
        <form>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kode Rak</label>
                    <input type="text" class="form-control" required>
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
                    <label class="form-label">Kapasitas</label>
                    <input type="number" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Lokasi</label>
                    <input type="text" class="form-control" required>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="button" class="btn btn-secondary" onclick="showForm('list')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Form -->
<div id="editForm" class="card" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">Edit Rak</h5>
        <form>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kode Rak</label>
                    <input type="text" class="form-control" value="A-1" required>
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
                    <label class="form-label">Kapasitas</label>
                    <input type="number" class="form-control" value="50" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Lokasi</label>
                    <input type="text" class="form-control" value="Lantai 1, Ruang Utama" required>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="button" class="btn btn-secondary" onclick="showForm('list')">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation -->
<div id="deleteForm" class="card" style="display: none;">
    <div class="card-body text-center">
        <h5 class="card-title">Hapus Rak</h5>
        <p>Apakah Anda yakin ingin menghapus rak ini?</p>
        <div class="text-center">
            <button type="button" class="btn btn-secondary" onclick="showForm('list')">Batal</button>
            <button type="button" class="btn btn-danger">Hapus</button>
        </div>
    </div>
</div>

<script>
function showForm(formType, shelfId = null) {
    // Hide all forms first
    document.getElementById('listView').style.display = 'none';
    document.getElementById('viewForm').style.display = 'none';
    document.getElementById('addForm').style.display = 'none';
    document.getElementById('editForm').style.display = 'none';
    document.getElementById('deleteForm').style.display = 'none';

    // Show the selected form
    switch(formType) {
        case 'list':
            document.getElementById('listView').style.display = 'block';
            break;
        case 'view':
            document.getElementById('viewForm').style.display = 'block';
            break;
        case 'add':
            document.getElementById('addForm').style.display = 'block';
            break;
        case 'edit':
            document.getElementById('editForm').style.display = 'block';
            break;
        case 'delete':
            document.getElementById('deleteForm').style.display = 'block';
            break;
    }
}

// Show list view by default
document.addEventListener('DOMContentLoaded', function() {
    showForm('list');
});
</script>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
