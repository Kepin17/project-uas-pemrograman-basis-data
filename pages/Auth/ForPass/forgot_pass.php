<?php
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Muat file .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Variabel konfigurasi email dari .env
$mailHost = $_ENV['MAIL_HOST'];
$mailPort = $_ENV['MAIL_PORT'];
$mailUsername = $_ENV['MAIL_USERNAME'];
$mailPassword = $_ENV['MAIL_PASSWORD'];
$mailEncryption = $_ENV['MAIL_ENCRYPTION'];
$mailFrom = $_ENV['MAIL_FROM'];
$mailFromName = $_ENV['MAIL_FROM_NAME'];

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

    // Hapus OTP lama jika ada
    $conn->query("DELETE FROM password_resets WHERE email = '$email'");

    $query = "INSERT INTO password_resets (email, otp, expired_at) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $email, $otp, $expired_at);

    if ($stmt->execute()) {
        // Gunakan PHPMailer untuk mengirim email
        $mail = new PHPMailer(true);

        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host       = $mailHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $mailUsername;
            $mail->Password   = $mailPassword;
            $mail->SMTPSecure = $mailEncryption;
            $mail->Port       = $mailPort;

            // Pengaturan Pengirim dan Penerima
            $mail->setFrom($mailFrom, $mailFromName);
            $mail->addAddress($email);

            // Konten Email
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Your OTP is: <b>$otp</b>. It will expire in 15 minutes.";
            $mail->AltBody = "Your OTP is: $otp. It will expire in 15 minutes.";

            // Kirim Email
            $mail->send();

            // Redirect jika sukses
            header("Location: " . BASE_URL . "/login/verify-otp?email=" . $email);
            exit();
        } catch (Exception $e) {
            $warning = "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $warning = 'Failed to save OTP. Please try again.';
    }
}
?>

<?php if ($warning): ?>
<div class="alert alert-warning"><?php echo $warning; ?></div>
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
