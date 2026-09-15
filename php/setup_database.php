<?php
/**
 * Database Setup Script
 * Run this file once to create database and tables
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

// Database connection without selecting database
$conn = mysqli_connect('localhost', 'root', '');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h2>Setting up Database...</h2>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS portofolio_db";
if (mysqli_query($conn, $sql)) {
    echo "<p style='color: green;'>✓ Database created successfully</p>";
} else {
    echo "<p style='color: red;'>✗ Error creating database: " . mysqli_error($conn) . "</p>";
}

// Select database
mysqli_select_db($conn, 'portofolio_db');

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "<p style='color: green;'>✓ Table 'users' created successfully</p>";
} else {
    echo "<p style='color: red;'>✗ Error creating table: " . mysqli_error($conn) . "</p>";
}

// Create projects table
$sql = "CREATE TABLE IF NOT EXISTS projects (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    technologies VARCHAR(255),
    github_url VARCHAR(255),
    demo_url VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sql)) {
    echo "<p style='color: green;'>✓ Table 'projects' created successfully</p>";
} else {
    echo "<p style='color: red;'>✗ Error creating table: " . mysqli_error($conn) . "</p>";
}

// Insert default admin user (password: admin123)
$username = 'haidar';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$name = 'Haidar Yahya Syarif';
$email = 'haidar@unnes.ac.id';

$sql = "INSERT INTO users (username, password, name, email) 
        VALUES ('$username', '$password', '$name', '$email')
        ON DUPLICATE KEY UPDATE username=username";

if (mysqli_query($conn, $sql)) {
    echo "<p style='color: green;'>✓ Default user created successfully</p>";
    echo "<p><strong>Username:</strong> haidar<br><strong>Password:</strong> admin123</p>";
} else {
    echo "<p style='color: red;'>✗ Error creating user: " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);

echo "<hr>";
echo "<h3>Setup Complete!</h3>";
echo "<p><a href='login.php' style='color: blue; text-decoration: underline;'>Go to Login Page</a></p>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Database Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h2 {
            color: #0d6efd;
        }
    </style>
</head>
</html>
