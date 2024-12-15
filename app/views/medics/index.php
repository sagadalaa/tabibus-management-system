<?php
/**
 * Medics Template for Clinic Management System
 * Author: Your Name
 * Description: Displays a list of medics with management options.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example medics data (replace with dynamic backend data)
$medics = $medics ?? [
    ['id' => 1, 'name' => 'Dr. Sarah Connor', 'specialization' => 'General Practitioner', 'email' => 'sarah@example.com', 'phone' => '123-456-7890'],
    ['id' => 2, 'name' => 'Dr. James Cameron', 'specialization' => 'Dentist', 'email' => 'james@example.com', 'phone' => '987-654-3210'],
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
    <meta name="description" content="Medics - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Medics | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="medics-container">
        <div class="medics-header">
            <h1><?= t('Medics') ?></h1>
            <div class="medics-actions">
                <a href="/medics/add" class="btn btn-primary"><?= t('Add New Medic') ?></a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="medics-table">
            <table>
                <thead>
                    <tr>
                        <th><?= t('Name') ?></th>
                        <th><?= t('Specialization') ?></th>
                        <th><?= t('Email') ?></th>
                        <th><?= t('Phone') ?></th>
                        <th><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($medics)): ?>
                        <?php foreach ($medics as $medic): ?>
                            <tr>
                                <td><?= htmlspecialchars($medic['name']) ?></td>
                                <td><?= htmlspecialchars($medic['specialization']) ?></td>
                                <td><?= htmlspecialchars($medic['email']) ?></td>
                                <td><?= htmlspecialchars($medic['phone']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/medics/<?= $medic['id'] ?>/edit" class="btn btn-edit"><?= t('Edit') ?></a>
                                        <form action="/medics/<?= $medic['id'] ?>/delete" method="POST" class="inline-form">
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('<?= t('Are you sure you want to delete this medic?') ?>')"><?= t('Delete') ?></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5"><?= t('No medics found.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
