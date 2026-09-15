<?php
/**
 * Projects Page
 * Display all user projects
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

require_once 'config.php';
requireLogin();

$user = getCurrentUser();

// Get all user's projects
$sql = "SELECT * FROM projects WHERE user_id = {$user['id']} ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$total_projects = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects - Portfolio Admin</title>
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
        
        .project-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
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
                <a href="add_project.php">
                    <i class="bi bi-plus-circle me-2"></i>Add Project
                </a>
            </li>
            <li>
                <a href="projects.php" class="active">
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
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="bi bi-folder-fill me-2"></i>My Projects</h4>
                <p class="text-muted mb-0">Total: <?= $total_projects ?> projects</p>
            </div>
            <a href="add_project.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Project
            </a>
        </div>
        
        <?php if ($total_projects > 0): ?>
            <?php while ($project = mysqli_fetch_assoc($result)): ?>
                <div class="project-card">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="mb-3">
                                <i class="bi bi-folder-fill text-primary me-2"></i>
                                <?= htmlspecialchars($project['title']) ?>
                            </h5>
                            
                            <p class="text-muted mb-3">
                                <?= htmlspecialchars($project['description']) ?>
                            </p>
                            
                            <div class="mb-3">
                                <strong class="text-muted d-block mb-2">
                                    <i class="bi bi-tools me-1"></i>Technologies:
                                </strong>
                                <?php 
                                $techs = explode(',', $project['technologies']);
                                foreach ($techs as $tech): 
                                ?>
                                    <span class="badge bg-primary me-1 mb-1"><?= trim($tech) ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="mb-3">
                                <?php if ($project['github_url']): ?>
                                    <a href="<?= $project['github_url'] ?>" target="_blank" class="btn btn-sm btn-outline-dark me-2">
                                        <i class="bi bi-github"></i> GitHub
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($project['demo_url']): ?>
                                    <a href="<?= $project['demo_url'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-box-arrow-up-right"></i> Demo
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                Created: <?= date('d M Y, H:i', strtotime($project['created_at'])) ?>
                            </small>
                        </div>
                        
                        <div class="col-md-3 text-end">
                            <a href="edit_project.php?id=<?= $project['id'] ?>" class="btn btn-warning btn-sm w-100 mb-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="delete_project.php?id=<?= $project['id'] ?>" 
                               class="btn btn-danger btn-sm w-100"
                               onclick="return confirm('Yakin ingin menghapus project \"<?= htmlspecialchars($project['title']) ?>\"?')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Belum ada project. <a href="add_project.php" class="alert-link">Tambahkan project pertama Anda!</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
