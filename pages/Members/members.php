<?php
$pageTitle = "Anggota Perpustakaan";
$currentPage = 'members';

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Anggota Perpustakaan</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
        <i class="fas fa-plus me-2"></i>Tambah Anggota
    </button>
</div>

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
                                <button class="btn btn-sm btn-info" title="Detail" data-bs-toggle="modal" data-bs-target="#viewMemberModal">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editMemberModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteMemberModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=Jane+Smith" class="rounded-circle me-2" width="40">
                                <div>
                                    <div class="fw-bold">Jane Smith</div>
                                    <small class="text-muted">ID: M002</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div><i class="fas fa-envelope me-1"></i> jane@example.com</div>
                            <small><i class="fas fa-phone me-1"></i> +62 812-3456-7891</small>
                        </td>
                        <td>Dosen</td>
                        <td>2023-02-20</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" title="Detail" data-bs-toggle="modal" data-bs-target="#viewMemberModal">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editMemberModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteMemberModal">
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

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Anggota Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
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
                            <label class="form-label">No. Telepon</label>
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
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Foto</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
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

<!-- View Member Modal -->
<div class="modal fade" id="viewMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&size=200" class="rounded-circle mb-3">
                        <h5 class="mb-0">John Doe</h5>
                        <small class="text-muted">ID: M001</small>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p>john@example.com</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. Telepon</label>
                            <p>+62 812-3456-7890</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Anggota</label>
                            <p>Mahasiswa</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <p>Jl. Contoh No. 123, Kota Contoh</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Bergabung</label>
                            <p>15 Januari 2023</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p><span class="badge bg-success">Aktif</span></p>
                        </div>
                    </div>
                </div>
                <hr>
                <h6 class="mb-3">Riwayat Peminjaman</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Harry Potter</td>
                                <td>2023-12-01</td>
                                <td>2023-12-15</td>
                                <td><span class="badge bg-success">Dikembalikan</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
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
                            <label class="form-label">No. Telepon</label>
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
                            <textarea class="form-control" rows="3">Jl. Contoh No. 123, Kota Contoh</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Foto</label>
                            <input type="file" class="form-control">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
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

<!-- Delete Member Modal -->
<div class="modal fade" id="deleteMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus anggota ini? Tindakan ini tidak dapat dibatalkan.</p>
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
