<?php 
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
require __DIR__ . '/../../../vendor/autoload.php';
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check for remember me cookie
if (!isset($_SESSION['email']) && isset($_COOKIE['remember_user'])) {
    $remembered_data = json_decode($_COOKIE['remember_user'], true);
    if ($remembered_data) {
        $user = checkUser($conn, $remembered_data['email'], $remembered_data['password'], 'petugas', true);
        if ($user) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['id_petugas'] = $user['id_petugas'];
            $_SESSION['nama_petugas'] = $user['nama_petugas'];
            $_SESSION['user_type'] = $user['jabatan'];
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }
    }
}

function checkUser($conn, $email, $password, $table, $from_cookie = false) {
    $query = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($from_cookie) {
            return $password === $user['password'] ? $user : false;
        } elseif (password_verify($password, $user['password'])) {
            // Rehash password if necessary
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE $table SET password = ? WHERE email = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param('ss', $newHash, $email);
                $updateStmt->execute();
            }
            return $user;
        }
    }
    return false;
}

function generateOTP() {
    return str_pad(strval(rand(0, 999999)), 6, '0', STR_PAD_LEFT);
}

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Login - Sistem Informasi Perpustakaan';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <h2 style='color: #333;'>Verifikasi Login</h2>
                </div>
                
                <div style='margin-bottom: 20px;'>
                    <p style='color: #555; font-size: 16px;'>Yth. Pengguna,</p>
                    <p style='color: #555; font-size: 16px;'>Kami menerima permintaan login untuk akun Anda. Berikut adalah kode OTP Anda:</p>
                </div>

                <div style='background-color: #f8f9fa; padding: 15px; text-align: center; margin-bottom: 20px; border-radius: 5px;'>
                    <span style='font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #007bff;'>{$otp}</span>
                </div>

                <div style='margin-bottom: 20px;'>
                    <p style='color: #555; font-size: 14px;'>Kode OTP ini akan kadaluarsa dalam 5 menit.</p>
                    <p style='color: #555; font-size: 14px;'>Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini atau hubungi administrator sistem.</p>
                </div>

                  <div style='background-color: #fff8e1; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>
                    <p style='color: #876d00; font-size: 14px; margin: 0;'>
                        <strong>Peringatan Keamanan:</strong> Jangan pernah membagikan kode OTP ini kepada siapapun, termasuk pihak yang mengaku sebagai staf perpustakaan.
                    </p>
                </div>

                <div style='border-top: 1px solid #ddd; padding-top: 15px; margin-top: 20px;'>
                    <p style='color: #777; font-size: 12px; text-align: center;'>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
                    <p style='color: #777; font-size: 12px; text-align: center;'>Sistem Informasi Perpustakaan &copy; " . date('Y') . "</p>
                </div>
            </div>
        ";

        $mail->AltBody = "Kode OTP Anda adalah: {$otp}\nKode ini akan kadaluarsa dalam 5 menit.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Check in petugas table
    $user = checkUser($conn, $email, $password, 'petugas');
    if ($user) {
        // Generate OTP
        $otp = generateOTP();
        
        // Store OTP in session (without starting a new session)
        $_SESSION['temp_login'] = [
            'email' => $user['email'],
            'id_petugas' => $user['id_petugas'],
            'nama_petugas' => $user['nama_petugas'],
            'id_jabatan' => $user['id_jabatan'],
            'remember' => $remember,
            'otp' => $otp,
            'otp_time' => time()
        ];

        // Send OTP via email
        if (sendOTP($email, $otp)) {
            header('Location: ' . BASE_URL . '/login/verify-email-otp');
            exit();
        } else {
            $_SESSION['login_error'] = "Failed to send OTP. Please try again.";
            header('Location: ' . BASE_URL . '/login');
            exit();
        }
    }

    $_SESSION['login_error'] = "Invalid email or password";
    header('Location: ' . BASE_URL . '/login');
    exit();
}
?>

<style>
.form-check {
    margin-bottom: 5px;
}
.forgot-password- {
    margin-top: 5px;
    margin-bottom: 15px;
}
.forgot-password- a {
    font-size: 14px;
    color: #6c757d;
    text-decoration: none;
    text-align: right;
}
.forgot-password- a:hover {
    text-decoration: underline;
}
</style>

<?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['login_error'];
                unset($_SESSION['login_error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
<?php endif; ?>

<form method="POST">
    <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        <label for="email">Email</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <label for="password">Password</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            Ingat saya selama 2 minggu
        </label>
    </div>
    <div class="forgot-password-">
        <a href="login/forgot-password">Forgot Password?</a>
    </div>
    <button type="submit" class="btn btn-primary btn-login">
        <i class="fas fa-sign-in-alt me-2"></i>Login To System
    </button>

</form>

<?php
    $subTitle ="Masuk ke sistem Informasi perpustakaan";

    $authContent = ob_get_clean();
    include __DIR__ . '/../../../layouts/auth.php';
?>