<?php
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../config/config.php';

ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if there's a temp login session
if (!isset($_SESSION['temp_login'])) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

$title = "Verify OTP";
$subTitle = "Enter the OTP sent to your email";
$warning = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_otp = $_POST['otp'];
    $stored_otp = $_SESSION['temp_login']['otp'];
    $otp_time = $_SESSION['temp_login']['otp_time'];

    // Check if OTP is expired (5 minutes)
    if (time() - $otp_time > 300) {
        $warning = 'OTP has expired. Please try logging in again.';
        // Clear temporary login data
        unset($_SESSION['temp_login']);
        header('Location: ' . BASE_URL . '/login');
        exit();
    }

    // Verify OTP
    if ($input_otp === $stored_otp) {
        // Set up session variables for logged in user
        $_SESSION['email'] = $_SESSION['temp_login']['email'];
        $_SESSION['id_petugas'] = $_SESSION['temp_login']['id_petugas'];
        $_SESSION['nama_petugas'] = $_SESSION['temp_login']['nama_petugas'];
        $_SESSION['id_jabatan'] = $_SESSION['temp_login']['id_jabatan'];

        // Handle remember me
        if ($_SESSION['temp_login']['remember']) {
            $cookie_data = [
                'email' => $_SESSION['temp_login']['email'],
                'password' => password_hash($_SESSION['temp_login']['email'], PASSWORD_DEFAULT)
            ];
            setcookie(
                'remember_user',
                json_encode($cookie_data),
                time() + (14 * 24 * 60 * 60), // 14 days
                '/'
            );
        }

        // Clear temporary login data
        unset($_SESSION['temp_login']);

        // Redirect to dashboard
        header('Location: ' . BASE_URL . '/dashboard');
        exit();
    } else {
        $warning = 'Invalid OTP. Please try again.';
    }
}
?>

<?php if ($warning): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo $warning; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="text-center mb-4">
    <p>We've sent an OTP to: <strong><?php echo $_SESSION['temp_login']['email']; ?></strong></p>
</div>

<form method="POST">
    <div class="mb-3">
        <label for="otp" class="form-label">Enter OTP</label>
        <input type="number" class="form-control" id="otp" name="otp" 
               placeholder="Enter 6-digit OTP" required maxlength="6" pattern="\d{6}">
        <div class="form-text">Please check your email for the OTP code</div>
    </div>
    <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
</form>

<div class="text-center mt-3">
    <a href="<?php echo BASE_URL; ?>/login" class="text-decoration-none">
        <i class="fas fa-arrow-left me-1"></i> Back to Login
    </a>
</div>

<?php
$authContent = ob_get_clean();
include __DIR__ . '/../../../layouts/auth.php';
?>
