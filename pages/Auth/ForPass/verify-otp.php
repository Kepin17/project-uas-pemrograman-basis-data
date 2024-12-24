<?php
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../config/config.php';
$subTitle = "Enter the OTP sent to your email to reset your password";

$warning = '';
$showPasswordFields = false;
$userName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $otp = isset($_POST['otp']) ? $_POST['otp'] : '';

    if ($otp) {
        // Verify OTP
        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ? AND otp = ?");
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $showPasswordFields = true;
            // Fetch user name
            $userStmt = $conn->prepare("SELECT nama_petugas FROM petugas WHERE email = ?");
            $userStmt->bind_param("s", $email);
            $userStmt->execute();
            $userResult = $userStmt->get_result();
            if ($userRow = $userResult->fetch_assoc()) {
                $userName = $userRow['nama_petugas'];
            }
        } else {
            $warning = 'Invalid OTP. Please try again.';
        }
    } else {
        // Handle password reset logic here
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword === $confirmPassword) {
            // Update password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $updateStmt = $conn->prepare("UPDATE petugas SET password = ? WHERE email = ?");
            $updateStmt->bind_param("ss", $hashedPassword, $email);
            $updateStmt->execute();

            // Redirect to login page or show success message
            header("Location:". BASE_URL . "/login");
            exit();
        } else {
            $warning = 'Passwords do not match. Please try again.';
        }
    }
}
$title = "Hi $userName";

ob_start();
?>

<?php if ($warning): ?>
    <div class="alert alert-warning" role="alert">
        <?php echo $warning; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
    <?php if ($showPasswordFields): ?>
       
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
        </div>
    <?php else: ?>
        <div class="mb-3">
            <label for="otp" class="form-label">OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter your OTP" required>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
</form>

<?php
$authContent = ob_get_clean();
include __DIR__ . '/../../../layouts/auth.php';
?>
