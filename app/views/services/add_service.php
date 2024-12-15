<?php
/**
 * Add Service Template for Clinic Management System
 * Author: Your Name
 * Description: Provides a form to add a new service to the clinic.
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
    <meta name="description" content="Add Service - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Add Service | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="add-service-container">
        <div class="add-service-header">
            <h1><?= t('Add New Service') ?></h1>
        </div>

        <div class="add-service-form-container">
            <form action="/services/create" method="POST" class="add-service-form">
                <?php if ($error): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="service_name"><?= t('Service Name') ?></label>
                    <input type="text" name="service_name" id="service_name" placeholder="<?= t('Enter service name') ?>" required>
                </div>
                <div class="form-group">
                    <label for="price"><?= t('Price') ?></label>
                    <input type="number" name="price" id="price" placeholder="<?= t('Enter price') ?>" required min="0" step="0.01">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= t('Add Service') ?></button>
                    <a href="/services" class="btn btn-secondary"><?= t('Cancel') ?></a>
                </div>
            </form>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
