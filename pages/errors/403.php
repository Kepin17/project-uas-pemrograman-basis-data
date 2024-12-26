<?php
$pageTitle = "403 Forbidden";
ob_start();
?>

<div class="text-center mt-5">
    <h1 class="display-1">403</h1>
    <h2>Akses Ditolak</h2>
    <p>Maaf, Anda tidak memiliki akses ke halaman ini.</p>
    <a href="<?= BASE_URL ?>/dashboard" class="btn btn-primary">Kembali ke Dashboard</a>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../../layouts/main.php');
?>
