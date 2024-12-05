<?php
$pageTitle = "Manajemen Staff";
$currentPage = "staff";
ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Manajemen Staff</h4>
    <div class="btn-group">
        <button class="btn btn-primary" onclick="showForm('list')">
            <i class="fas fa-list me-2"></i>List Staff
        </button>
        <button class="btn btn-success" onclick="showForm('add')">
            <i class="fas fa-plus me-2"></i>Tambah Staff
        </button>
    </div>
</div>

<!-- List View -->
<div id="listView">
    <!-- Table Staff -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Staff</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>johndoe</td>
                            <td>john@example.com</td>
                            <td>+62 812-3456-7890</td>
                            <td>Jl. Contoh No. 123</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" onclick="showForm('view')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="showForm('edit')">
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

<!-- View Form -->
<div id="viewForm" class="card" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">Detail Staff</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Staff</label>
                <p>John Doe</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Username</label>
                <p>johndoe</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Email</label>
                <p>john@example.com</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">No. Telepon</label>
                <p>+62 812-3456-7890</p>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Alamat</label>
                <p>Jl. Contoh No. 123</p>
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
        <h5 class="card-title">Tambah Staff Baru</h5>
        <form id="addStaffForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Staff</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon</label>
                    <input type="tel" class="form-control" name="telepon" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3" required></textarea>
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
        <h5 class="card-title">Edit Staff</h5>
        <form id="editStaffForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Staff</label>
                    <input type="text" class="form-control" name="nama" value="John Doe" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="johndoe" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="john@example.com" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon</label>
                    <input type="tel" class="form-control" name="telepon" value="+62 812-3456-7890" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3" required>Jl. Contoh No. 123</textarea>
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
        <h5 class="card-title">Hapus Staff</h5>
        <p>Apakah Anda yakin ingin menghapus staff ini?</p>
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
