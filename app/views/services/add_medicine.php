<?php
/**
 * Add Medicine Template for Clinic Management System
 * Author: Your Name
 * Description: Provides a form to add new medicine details to the clinic system.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Display optional error or success messages
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Add Medicine - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Add Medicine | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="add-medicine-container">
        <div class="add-medicine-header">
            <h1><?= t('Add New Medicine') ?></h1>
        </div>

        <div class="add-medicine-form-container">
            <form action="/medicines/create" method="POST" class="add-medicine-form">
                <?php if ($error): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="medicine_name"><?= t('Medicine Name') ?></label>
                    <input type="text" name="medicine_name" id="medicine_name" placeholder="<?= t('Enter medicine name') ?>" required>
                </div>
                <div class="form-group">
                    <label for="dosage"><?= t('Dosage (e.g., 500mg)') ?></label>
                    <input type="text" name="dosage" id="dosage" placeholder="<?= t('Enter dosage information') ?>" required>
                </div>
                <div class="form-group">
                    <label for="usage_instructions"><?= t('Usage Instructions') ?></label>
                    <textarea name="usage_instructions" id="usage_instructions" rows="3" placeholder="<?= t('Enter usage instructions') ?>" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= t('Add Medicine') ?></button>
                    <a href="/medicines" class="btn btn-secondary"><?= t('Cancel') ?></a>
                </div>
            </form>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
