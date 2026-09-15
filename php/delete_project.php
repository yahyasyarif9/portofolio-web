<?php
/**
 * Delete Project
 * Delete project dari database
 * 
 * @author Haidar Yahya Syarif
 * @nim 2504140052
 */

require_once 'config.php';
requireLogin();

$user = getCurrentUser();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Check if project belongs to current user
    $check_sql = "SELECT * FROM projects WHERE id = $id AND user_id = {$user['id']}";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Delete project
        $delete_sql = "DELETE FROM projects WHERE id = $id AND user_id = {$user['id']}";
        
        if (mysqli_query($conn, $delete_sql)) {
            header('Location: projects.php?msg=deleted');
        } else {
            header('Location: projects.php?error=delete_failed');
        }
    } else {
        header('Location: projects.php?error=not_found');
    }
} else {
    header('Location: projects.php');
}

exit();
?>
