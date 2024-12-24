<?php
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../config/config.php';
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
.form-floating {
    margin-bottom: 15px;
}
</style>

<?php if (isset($_SESSION['register_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php 
        echo $_SESSION['register_error'];
        unset($_SESSION['register_error']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>/register/process">
    <div class="form-floating">
        <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" placeholder="Nama Lengkap" required>
        <label for="nama_anggota">Nama Lengkap</label>
    </div>
    <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        <label for="email">Email</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" required>
        <label for="no_telp">Nomor Telepon</label>
    </div>
    <div class="form-floating">
        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" style="height: 100px" required></textarea>
        <label for="alamat">Alamat</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <label for="password">Password</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
        <label for="confirm_password">Konfirmasi Password</label>
    </div>
    <button type="submit" class="btn btn-primary btn-login mt-3 w-100">
        <i class="fas fa-user-plus me-2"></i>Daftar Sebagai Anggota
    </button>
    <div class="text-center mt-3">
        <span>Sudah punya akun? </span>
        <a href="<?= BASE_URL ?>/login">Login disini</a>
    </div>
</form>

<?php
    $subTitle = "Pendaftaran Anggota Perpustakaan";
    $authContent = ob_get_clean();
    include __DIR__ . '/../../../layouts/auth.php';
?>
