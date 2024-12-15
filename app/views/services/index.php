<?php
/**
 * Services Template for Clinic Management System
 * Author: Your Name
 * Description: Displays a list of services offered by the clinic with management options.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example service data (replace with dynamic backend data)
$services = $services ?? [
    ['id' => 1, 'name' => 'General Checkup', 'price' => 50],
    ['id' => 2, 'name' => 'Dental Cleaning', 'price' => 80],
];

// Display optional error or success messages
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clinic Services - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Services | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="services-container">
        <div class="services-header">
            <h1><?= t('Clinic Services') ?></h1>
            <div class="services-actions">
                <a href="/services/add" class="btn btn-primary"><?= t('Add New Service') ?></a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="services-table">
            <table>
                <thead>
                    <tr>
                        <th><?= t('Service Name') ?></th>
                        <th><?= t('Price') ?></th>
                        <th><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?= htmlspecialchars($service['name']) ?></td>
                                <td>$<?= number_format($service['price'], 2) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/services/<?= $service['id'] ?>/edit" class="btn btn-edit"><?= t('Edit') ?></a>
                                        <form action="/services/<?= $service['id'] ?>/delete" method="POST" class="inline-form">
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('<?= t('Are you sure you want to delete this service?') ?>')"><?= t('Delete') ?></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3"><?= t('No services found.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
