<?php
/**
 * Backup and Restore Template for Clinic Management System
 * Author: Your Name
 * Description: Provides an interface for creating backups and restoring system data.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example status messages (replace with backend integration)
$lastBackup = '2024-12-01 12:00:00'; // Replace with actual last backup timestamp
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Backup and Restore - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Backup & Restore | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="backup-restore-container">
        <div class="backup-restore-header">
            <h1><?= t('Backup & Restore') ?></h1>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="backup-section">
            <h2><?= t('Create Backup') ?></h2>
            <p><?= t('Last Backup: ') . htmlspecialchars($lastBackup) ?></p>
            <form action="/system/backup/create" method="POST">
                <button type="submit" class="btn btn-primary"><?= t('Create Backup') ?></button>
            </form>
        </div>

        <div class="restore-section">
            <h2><?= t('Restore Data') ?></h2>
            <form action="/system/backup/restore" method="POST" enctype="multipart/form-data" class="restore-form">
                <div class="form-group">
                    <label for="backup_file"><?= t('Upload Backup File') ?></label>
                    <input type="file" name="backup_file" id="backup_file" required>
                </div>
                <button type="submit" class="btn btn-secondary"><?= t('Restore Backup') ?></button>
            </form>
        </div>

        <div class="instructions-section">
            <h2><?= t('Instructions') ?></h2>
            <p><?= t('1. Click "Create Backup" to generate a full backup of the system.') ?></p>
            <p><?= t('2. To restore data, upload a valid backup file using the "Restore Backup" option.') ?></p>
            <p><?= t('3. Ensure that the backup file is recent and from a trusted source.') ?></p>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
