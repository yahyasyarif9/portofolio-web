<?php
/**
 * Logout Page
 * Clear session and cookies
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

require_once 'config.php';

// Destroy session
session_destroy();

// Clear cookies
setcookie('user_id', '', time() - 3600, COOKIE_PATH);
setcookie('username', '', time() - 3600, COOKIE_PATH);

// Redirect to login
header('Location: login.php');
exit();
?>
