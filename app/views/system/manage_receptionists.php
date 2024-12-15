<?php
/**
 * Manage Receptionists Template for Clinic Management System
 * Author: Your Name
 * Description: Allows the clinic admin to manage receptionist accounts.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example receptionist data (replace with dynamic backend data)
$receptionists = $receptionists ?? [
    ['id' => 1, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'status' => 'Active'],
    ['id' => 2, 'name' => 'Bob Smith', 'email' => 'bob@example.com', 'status' => 'Disabled'],
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
    <meta name="description" content="Manage Receptionists - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Manage Receptionists | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="receptionists-container">
        <div class="receptionists-header">
            <h1><?= t('Manage Receptionists') ?></h1>
            <div class="actions">
                <a href="/system/receptionists/add" class="btn btn-primary"><?= t('Add New Receptionist') ?></a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="receptionists-table">
            <table>
                <thead>
                    <tr>
                        <th><?= t('Name') ?></th>
                        <th><?= t('Email') ?></th>
                        <th><?= t('Status') ?></th>
                        <th><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($receptionists)): ?>
                        <?php foreach ($receptionists as $receptionist): ?>
                            <tr>
                                <td><?= htmlspecialchars($receptionist['name']) ?></td>
                                <td><?= htmlspecialchars($receptionist['email']) ?></td>
                                <td><?= htmlspecialchars($receptionist['status']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/system/receptionists/<?= $receptionist['id'] ?>/edit" class="btn btn-edit"><?= t('Edit') ?></a>
                                        <form action="/system/receptionists/<?= $receptionist['id'] ?>/delete" method="POST" class="inline-form">
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('<?= t('Are you sure you want to delete this receptionist?') ?>')"><?= t('Delete') ?></button>
                                        </form>
                                        <?php if ($receptionist['status'] === 'Active'): ?>
                                            <form action="/system/receptionists/<?= $receptionist['id'] ?>/disable" method="POST" class="inline-form">
                                                <button type="submit" class="btn btn-disable"><?= t('Disable') ?></button>
                                            </form>
                                        <?php else: ?>
                                            <form action="/system/receptionists/<?= $receptionist['id'] ?>/enable" method="POST" class="inline-form">
                                                <button type="submit" class="btn btn-enable"><?= t('Enable') ?></button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4"><?= t('No receptionists found.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
