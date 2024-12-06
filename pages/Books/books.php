<?php
$pageTitle = "Manajemen Buku - Perpustakaan";
$currentPage = 'books';

$query = $conn->query("SELECT * FROM buku ORDER BY id_buku DESC") or die(mysqli_error($conn));

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Manajemen Buku</h4>
    <div class="btn-group">
        <button class="btn btn-primary" onclick="showForm('list')">
            <i class="fas fa-list me-2"></i>List Buku
        </button>
        <button class="btn btn-success" onclick="showForm('add')">
            <i class="fas fa-plus me-2"></i>Tambah Buku
        </button>
    </div>
</div>

<!-- List View -->
<div id="listView">
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
                            <th>Stok</th>
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
                            <td>5</td>
                            <td><span class="badge bg-success">Tersedia</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" onclick="showForm('edit')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="showForm('delete')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Form -->
<div id="addForm" class="card" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">Tambah Buku Baru</h5>
        <form>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ISBN</label>
                    <input type="text" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Penulis</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        <option value="1">Fiksi</option>
                        <option value="2">Non-Fiksi</option>
                        <option value="3">Pendidikan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Rak</label>
                    <select class="form-select" required>
                        <option value="">Pilih Rak</option>
                        <option value="1">Rak A</option>
                        <option value="2">Rak B</option>
                        <option value="3">Rak C</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" rows="3"></textarea>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-secondary" onclick="showForm('list')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Form -->
<div id="editForm" class="card" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">Edit Buku</h5>
        <form>
            <!-- Same form fields as Add Form but with pre-filled values -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" value="Harry Potter and the Philosopher's Stone" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ISBN</label>
                    <input type="text" class="form-control" value="978-0-7475-3269-9" required>
                </div>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-secondary" onclick="showForm('list')">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation -->
<div id="deleteForm" class="card" style="display: none;">
    <div class="card-body text-center">
        <h5 class="card-title">Hapus Buku</h5>
        <p>Apakah Anda yakin ingin menghapus buku ini?</p>
        <div class="text-center">
            <button type="button" class="btn btn-secondary" onclick="showForm('list')">Batal</button>
            <button type="button" class="btn btn-danger">Hapus</button>
        </div>
    </div>
</div>

<script>
function showForm(formType) {
    // Hide all forms first
    document.getElementById('listView').style.display = 'none';
    document.getElementById('addForm').style.display = 'none';
    document.getElementById('editForm').style.display = 'none';
    document.getElementById('deleteForm').style.display = 'none';

    // Show the selected form
    switch(formType) {
        case 'list':
            document.getElementById('listView').style.display = 'block';
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
