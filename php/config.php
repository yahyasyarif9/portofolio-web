<?php
/**
 * Database Configuration
 * Praktikum 3 - PHP dengan MySQL
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portofolio_db');

// Create connection using mysqli
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cookie configuration
define('COOKIE_EXPIRE', time() + (86400 * 30)); // 30 days
define('COOKIE_PATH', '/');

/**
 * Function to check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

/**
 * Function to check login with cookie
 */
function checkLoginCookie() {
    if (!isLoggedIn() && isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
        return true;
    }
    return isLoggedIn();
}

/**
 * Function to redirect if not logged in
 */
function requireLogin() {
    if (!checkLoginCookie()) {
        header('Location: login.php');
        exit();
    }
}

/**
 * Function to sanitize input
 */
function sanitize($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

/**
 * Function to get current user info
 */
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'name' => $_SESSION['name'] ?? 'User'
        ];
    }
    return null;
}
?>
