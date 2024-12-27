<?php
require_once __DIR__ . '/../../../config/connection.php';
$title = "Verify Email";
$subTitle = "Enter your email to receive OTP";

function generateOTP() {
    return sprintf("%06d", mt_rand(0, 999999));
}

$warning = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $otp = generateOTP();
    $expired_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    
    $query = "INSERT INTO password_resets (email, otp, expired_at) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $email, $otp, $expired_at);
    
    if ($stmt->execute()) {
        // Send email with OTP
        $to = $email;
        $subject = "Password Reset OTP";
        $message = "Your OTP is: " . $otp;
        mail($to, $subject, $message);
        
        header("Location: " . BASE_URL . "/login/verify-otp?email=" . $email);
        exit();
    } else {
        $warning = 'Failed to send OTP. Please try again.';
    }
}
ob_start();
?>

<?php if ($warning): ?>
    <div class="alert alert-warning" role="alert">
        <?php echo $warning; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        <div class="form-text">We'll send an OTP to your email</div>
    </div>
    <button type="submit" class="btn btn-primary w-100">Send OTP</button>
</form>

<?php
$authContent = ob_get_clean();
include __DIR__ . '/../../../layouts/auth.php';
?>