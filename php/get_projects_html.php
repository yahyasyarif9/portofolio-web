<?php
/**
 * Get Projects HTML for Portfolio
 * Returns HTML for projects section
 */

require_once 'config.php';

// Get all projects
$sql = "SELECT * FROM projects ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0):
    while ($project = mysqli_fetch_assoc($result)):
        $image = $project['image_url'] ?: "https://via.placeholder.com/500x300/0d6efd/ffffff?text=" . urlencode($project['title']);
        $techs = explode(',', $project['technologies']);
        $colors = ['primary', 'success', 'danger', 'warning', 'info'];
?>
        <div class="col-md-6 mb-4">
            <div class="project-card">
                <div class="project-image">
                    <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
                    <div class="project-overlay">
                        <?php if ($project['github_url']): ?>
                            <a href="<?= htmlspecialchars($project['github_url']) ?>" target="_blank" class="btn btn-light btn-sm">
                                <i class="bi bi-github"></i> GitHub
                            </a>
                        <?php endif; ?>
                        <?php if ($project['demo_url']): ?>
                            <a href="<?= htmlspecialchars($project['demo_url']) ?>" target="_blank" class="btn btn-light btn-sm ms-1">
                                <i class="bi bi-box-arrow-up-right"></i> Demo
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="project-content">
                    <h4><?= htmlspecialchars($project['title']) ?></h4>
                    <p><?= htmlspecialchars(substr($project['description'], 0, 150)) . (strlen($project['description']) > 150 ? '...' : '') ?></p>
                    <div class="project-tags">
                        <?php foreach ($techs as $index => $tech): 
                            $color = $colors[$index % count($colors)];
                        ?>
                            <span class="badge bg-<?= $color ?> <?= $color == 'warning' ? 'text-dark' : '' ?>">
                                <?= trim(htmlspecialchars($tech)) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    endwhile;
else:
?>
    <div class="col-12">
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Belum ada project. <a href="php/login.php" class="alert-link">Login sebagai admin</a> untuk menambahkan project.
        </div>
    </div>
<?php endif; ?>
