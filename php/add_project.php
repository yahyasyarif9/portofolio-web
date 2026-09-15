<?php
/**
 * Add Project Page
 * Form untuk menambahkan project menggunakan $_REQUEST
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

require_once 'config.php';
requireLogin();

$user = getCurrentUser();
$success = '';
$error = '';

// Handle form submission using $_REQUEST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menggunakan $_REQUEST (bisa menerima POST, GET, dan COOKIE)
    $title = sanitize($_REQUEST['title'] ?? '');
    $description = sanitize($_REQUEST['description'] ?? '');
    $technologies = sanitize($_REQUEST['technologies'] ?? '');
    $github_url = sanitize($_REQUEST['github_url'] ?? '');
    $demo_url = sanitize($_REQUEST['demo_url'] ?? '');
    $image_url = sanitize($_REQUEST['image_url'] ?? '');
    
    // Validation
    if (empty($title)) {
        $error = 'Judul project harus diisi!';
    } elseif (empty($description)) {
        $error = 'Deskripsi project harus diisi!';
    } elseif (empty($technologies)) {
        $error = 'Teknologi harus diisi!';
    } else {
        // Insert to database using mysqli
        $sql = "INSERT INTO projects (user_id, title, description, technologies, github_url, demo_url, image_url) 
                VALUES (
                    {$user['id']}, 
                    '$title', 
                    '$description', 
                    '$technologies', 
                    '$github_url', 
                    '$demo_url', 
                    '$image_url'
                )";
        
        if (mysqli_query($conn, $sql)) {
            $success = 'Project berhasil ditambahkan!';
            // Clear form
            $_POST = array();
            header('refresh:2;url=dashboard.php');
        } else {
            $error = 'Gagal menambahkan project: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project - Portfolio Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #0d6efd 0%, #084298 100%);
            color: white;
            padding: 20px;
            z-index: 1000;
        }
        
        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 10px;
        }
        
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .main-content {
            margin-left: 270px;
            padding: 30px;
        }
        
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-person-circle me-2"></i>
            Portfolio Admin
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="add_project.php" class="active">
                    <i class="bi bi-plus-circle me-2"></i>Add Project
                </a>
            </li>
            <li>
                <a href="projects.php">
                    <i class="bi bi-folder-fill me-2"></i>My Projects
                </a>
            </li>
            <li>
                <a href="../index.php" target="_blank">
                    <i class="bi bi-globe me-2"></i>View Website
                </a>
            </li>
            <li>
                <a href="logout.php" style="background: rgba(220, 53, 69, 0.2);">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="mb-4">
            <h4><i class="bi bi-plus-circle me-2"></i>Add New Project</h4>
            <p class="text-muted">Tambahkan project atau karya Anda ke dalam portfolio</p>
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
        
        <div class="form-card">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">
                            Judul Project <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="title" name="title" 
                               placeholder="Contoh: E-Commerce Website" required
                               value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                        <small class="text-muted">Nama project atau karya Anda</small>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">
                            Deskripsi <span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="5" placeholder="Jelaskan tentang project Anda..." required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        <small class="text-muted">Deskripsi lengkap tentang project (fitur, tujuan, dll)</small>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="technologies" class="form-label">
                            Teknologi <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="technologies" name="technologies" 
                               placeholder="HTML, CSS, JavaScript, PHP, MySQL" required
                               value="<?= htmlspecialchars($_POST['technologies'] ?? '') ?>">
                        <small class="text-muted">Pisahkan dengan koma (,)</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="github_url" class="form-label">
                            GitHub URL
                        </label>
                        <input type="url" class="form-control" id="github_url" name="github_url" 
                               placeholder="https://github.com/username/repo"
                               value="<?= htmlspecialchars($_POST['github_url'] ?? '') ?>">
                        <small class="text-muted">Link repository GitHub (opsional)</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="demo_url" class="form-label">
                            Demo URL
                        </label>
                        <input type="url" class="form-control" id="demo_url" name="demo_url" 
                               placeholder="https://demo.example.com"
                               value="<?= htmlspecialchars($_POST['demo_url'] ?? '') ?>">
                        <small class="text-muted">Link demo project (opsional)</small>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="image_url" class="form-label">
                            Image URL
                        </label>
                        <input type="url" class="form-control" id="image_url" name="image_url" 
                               placeholder="https://example.com/image.png"
                               value="<?= htmlspecialchars($_POST['image_url'] ?? '') ?>">
                        <small class="text-muted">Link gambar screenshot project (opsional)</small>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Project
                    </button>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="reset" class="btn btn-outline-danger ms-auto">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Info Box -->
        <div class="alert alert-info mt-4">
            <h6 class="alert-heading">
                <i class="bi bi-info-circle me-2"></i>Informasi
            </h6>
            <p class="mb-0">
                <strong>Form ini menggunakan $_REQUEST</strong> untuk menerima data dari method POST.
                $_REQUEST dapat menerima data dari $_GET, $_POST, dan $_COOKIE.
            </p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
