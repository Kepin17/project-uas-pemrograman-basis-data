<?php
$pageTitle = "Dashboard - Perpustakaan";
$currentPage = 'dashboard';

ob_start();
?>

<div class="main-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Dashboard</h4>
    <div class="d-flex align-items-center">
        <span class="me-2"><?php echo date('d M Y'); ?></span>
        <div class="btn-group">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-1"></i> Admin
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/pages/Auth/Login/logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-xl bg-primary bg-opacity-10 rounded">
                            <i class="fas fa-book fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0">Total Buku</h6>
                        <h3 class="mb-0">150</h3>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>12% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-xl bg-success bg-opacity-10 rounded">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0">Total Anggota</h6>
                        <h3 class="mb-0">50</h3>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>8% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-xl bg-warning bg-opacity-10 rounded">
                            <i class="fas fa-hand-holding fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0">Peminjaman Aktif</h6>
                        <h3 class="mb-0">25</h3>
                        <small class="text-muted">
                            <i class="fas fa-equals me-1"></i>Sama dengan bulan lalu
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-xl bg-danger bg-opacity-10 rounded">
                            <i class="fas fa-clock fa-2x text-danger"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0">Keterlambatan</h6>
                        <h3 class="mb-0">5</h3>
                        <small class="text-danger">
                            <i class="fas fa-arrow-up me-1"></i>2 dari minggu lalu
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <!-- Recent Borrowings -->
    <div class="col-12 col-xl-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Peminjaman Terbaru</h5>
                <button class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe" class="rounded-circle me-2" width="32">
                                        John Doe
                                    </div>
                                </td>
                                <td>Harry Potter</td>
                                <td>20 Dec 2023</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Jane+Smith" class="rounded-circle me-2" width="32">
                                        Jane Smith
                                    </div>
                                </td>
                                <td>Lord of the Rings</td>
                                <td>19 Dec 2023</td>
                                <td><span class="badge bg-warning">Due Soon</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Books -->
    <div class="col-12 col-xl-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Buku Terpopuler</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Bulan Ini
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                        <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                        <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Kategori</th>
                                <th>Total Peminjaman</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/32x48" class="me-2">
                                        Harry Potter
                                    </div>
                                </td>
                                <td>Fiksi</td>
                                <td>25</td>
                                <td>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/32x48" class="me-2">
                                        Lord of the Rings
                                    </div>
                                </td>
                                <td>Fiksi</td>
                                <td>20</td>
                                <td>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
