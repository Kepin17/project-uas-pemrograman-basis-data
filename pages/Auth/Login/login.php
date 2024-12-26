<?php 
require_once __DIR__ . '/../../../config/connection.php';
require_once __DIR__ . '/../../../config/config.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Check in petugas table
    $user = checkUser($conn, $email, $password, 'petugas');
    if ($user) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['id_petugas'] = $user['id_petugas'];
        $_SESSION['nama_petugas'] = $user['nama_petugas'];
        $_SESSION['id_jabatan'] = $user['id_jabatan'];

        // Set remember me cookie if checked
        if ($remember) {
            $cookie_data = json_encode([
                'email' => $user['email'],
                'password' => $user['password'] // Store hashed password
            ]);
            setcookie('remember_user', $cookie_data, time() + (14 * 24 * 60 * 60), '/'); // 14 days
        }

        header('Location: ' . BASE_URL . '/dashboard');
        exit();
    }

    // If no match found
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