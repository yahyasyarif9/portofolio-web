<?php
/**
 * Login Page with Cookie & Session
 * Praktikum 3 - PHP
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

require_once 'config.php';

// Check if already logged in
if (checkLoginCookie()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Using $_REQUEST (can accept both POST and GET)
    $username = sanitize($_REQUEST['username'] ?? '');
    $password = $_REQUEST['password'] ?? '';
    $remember = isset($_REQUEST['remember']);
    
    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi!';
    } else {
        // Query user from database
        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['login_time'] = time();
                
                // Set cookie if remember me is checked
                if ($remember) {
                    setcookie('user_id', $user['id'], COOKIE_EXPIRE, COOKIE_PATH);
                    setcookie('username', $user['username'], COOKIE_EXPIRE, COOKIE_PATH);
                }
                
                $success = 'Login berhasil! Redirecting...';
                header('refresh:1;url=dashboard.php');
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username tidak ditemukan!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portfolio Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 0%, #084298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h2 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #6c757d;
        }
        
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #0d6efd 0%, #084298 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
        
        .alert {
            border-radius: 10px;
        }
        
        .demo-credentials {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        
        .demo-credentials strong {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-person-circle" style="font-size: 4rem; color: #0d6efd;"></i>
            <h2>Login Admin</h2>
            <p>Portfolio Management System</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">
                    <i class="bi bi-person-fill me-1"></i>Username
                </label>
                <input type="text" class="form-control" id="username" name="username" 
                       placeholder="Masukkan username" required autofocus
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock-fill me-1"></i>Password
                </label>
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Masukkan password" required>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Remember me (30 days)
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
        </form>
        
        <div class="demo-credentials">
            <strong>Demo Credentials:</strong><br>
            <i class="bi bi-person me-1"></i><strong>Username:</strong> haidar<br>
            <i class="bi bi-key me-1"></i><strong>Password:</strong> admin123
        </div>
        
        <div class="text-center mt-3">
            <a href="../index.html" class="text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Homepage
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
