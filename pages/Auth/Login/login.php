<?php 
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../config/config.php';
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Query to check user credentials
    $query = "SELECT * FROM anggota WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];

        // Handle remember me
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+14 days'));
            
            // Store remember me token in database
            $query = "INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iss", $user['id'], $token, $expires);
            $stmt->execute();

            // Set remember me cookie
            setcookie('remember_token', $token, strtotime('+14 days'), '/');
        }

        // Redirect to dashboard
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    } else {
        $_SESSION['login_error'] = 'Email atau password salah!';
    }
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
    <div class="text-center mt-3">
        <span>Don't have an account? </span>
        <a href="<?= BASE_URL ?>/register">Register here</a>
    </div>
</form>

<?php
    $subTitle ="Masuk ke sistem Informasi perpustakaan";

    $authContent = ob_get_clean();
    include __DIR__ . '/../../../layouts/auth.php';
?>