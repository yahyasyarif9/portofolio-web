<?php
/**
 * Dashboard Page
 * Display projects and management
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

require_once 'config.php';
requireLogin();

$user = getCurrentUser();

// Get user's projects
$sql = "SELECT * FROM projects WHERE user_id = {$user['id']} ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= $user['name'] ?></title>
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
        
        .top-bar {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stats-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 5px;
        }
        
        .project-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd 0%, #084298 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
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
                <a href="dashboard.php" class="active">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="add_project.php">
                    <i class="bi bi-plus-circle me-2"></i>Add Project
                </a>
            </li>
            <li>
                <a href="projects.php">
                    <i class="bi bi-folder-fill me-2"></i>My Projects
                </a>
            </li>
            <li>
                <a href="../index.html" target="_blank">
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
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <h4 class="mb-0">Dashboard</h4>
                <p class="text-muted mb-0">Selamat datang, <?= $user['name'] ?>!</p>
            </div>
            <div class="user-info">
                <div>
                    <strong><?= $user['name'] ?></strong><br>
                    <small class="text-muted">@<?= $user['username'] ?></small>
                </div>
                <div class="user-avatar">
                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="row">
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="bi bi-folder-fill" style="font-size: 2rem; color: #0d6efd;"></i>
                    <h3><?= mysqli_num_rows($result) ?></h3>
                    <p class="text-muted mb-0">Total Projects</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="bi bi-clock-history" style="font-size: 2rem; color: #198754;"></i>
                    <h3><?= date('d', time() - $_SESSION['login_time']) ?></h3>
                    <p class="text-muted mb-0">Days Active</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="bi bi-calendar-event" style="font-size: 2rem; color: #ffc107;"></i>
                    <h3><?= date('M Y') ?></h3>
                    <p class="text-muted mb-0">Current Month</p>
                </div>
            </div>
        </div>
        
        <!-- Recent Projects -->
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5><i class="bi bi-folder me-2"></i>Recent Projects</h5>
                <a href="add_project.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Project
                </a>
            </div>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($project = mysqli_fetch_assoc($result)): ?>
                    <div class="project-card">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2"><?= htmlspecialchars($project['title']) ?></h5>
                                <p class="text-muted mb-2"><?= htmlspecialchars(substr($project['description'], 0, 150)) ?>...</p>
                                <div class="mb-2">
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach ($techs as $tech): 
                                    ?>
                                        <span class="badge bg-primary me-1"><?= trim($tech) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    <?= date('d M Y', strtotime($project['created_at'])) ?>
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <?php if ($project['github_url']): ?>
                                    <a href="<?= $project['github_url'] ?>" target="_blank" class="btn btn-sm btn-outline-dark mb-2">
                                        <i class="bi bi-github"></i> GitHub
                                    </a>
                                <?php endif; ?>
                                <br>
                                <a href="edit_project.php?id=<?= $project['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="delete_project.php?id=<?= $project['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin ingin menghapus project ini?')">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada project. <a href="add_project.php">Tambahkan project pertama Anda!</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
