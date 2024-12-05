<?php
$pageTitle = "Anggota Perpustakaan";
$currentPage = 'members';

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Anggota Perpustakaan</h4>
    <div class="btn-group">
        <button class="btn btn-primary" onclick="showForm('list')">
            <i class="fas fa-list me-2"></i>List Anggota
        </button>
        <button class="btn btn-success" onclick="showForm('add')">
            <i class="fas fa-plus me-2"></i>Tambah Anggota
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
                    <input type="text" class="form-control" placeholder="Cari anggota...">
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="2">Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="1">Mahasiswa</option>
                        <option value="2">Dosen</option>
                        <option value="3">Umum</option>
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

    <!-- Members Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Anggota</th>
                            <th>Kontak</th>
                            <th>Jenis</th>
                            <th>Bergabung</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=John+Doe" class="rounded-circle me-2" width="40">
                                    <div>
                                        <div class="fw-bold">John Doe</div>
                                        <small class="text-muted">ID: M001</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="fas fa-envelope me-1"></i> john@example.com</div>
                                <small><i class="fas fa-phone me-1"></i> +62 812-3456-7890</small>
                            </td>
                            <td>Mahasiswa</td>
                            <td>2023-01-15</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" title="Detail" onclick="showForm('view')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Edit" onclick="showForm('edit')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus" onclick="showForm('delete')">
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

<!-- View Form -->
<div id="viewForm" class="card" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">Detail Anggota</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <p>John Doe</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">ID Anggota</label>
                <p>M001</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Email</label>
                <p>john@example.com</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Nomor Telepon</label>
                <p>+62 812-3456-7890</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Jenis Anggota</label>
                <p>Mahasiswa</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Status</label>
                <p><span class="badge bg-success">Aktif</span></p>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Alamat</label>
                <p>Jl. Contoh No. 123, Kota Contoh</p>
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
        <h5 class="card-title">Tambah Anggota Baru</h5>
        <form>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Anggota</label>
                    <select class="form-select" required>
                        <option value="">Pilih Jenis</option>
                        <option value="1">Mahasiswa</option>
                        <option value="2">Dosen</option>
                        <option value="3">Umum</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" rows="3" required></textarea>
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
        <h5 class="card-title">Edit Anggota</h5>
        <form>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="John Doe" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="john@example.com" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" value="+62 812-3456-7890" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Anggota</label>
                    <select class="form-select" required>
                        <option value="1" selected>Mahasiswa</option>
                        <option value="2">Dosen</option>
                        <option value="3">Umum</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" rows="3" required>Jl. Contoh No. 123, Kota Contoh</textarea>
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
        <h5 class="card-title">Hapus Anggota</h5>
        <p>Apakah Anda yakin ingin menghapus anggota ini?</p>
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
