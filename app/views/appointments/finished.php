<?php
/**
 * Finished Appointments Template for Clinic Management System
 * Author: Your Name
 * Description: Displays a list of finished appointments with details and management options.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example finished appointment data (replace with dynamic backend data)
$finishedAppointments = $finishedAppointments ?? [
    [
        'id' => 1,
        'date' => '2024-12-01',
        'time' => '10:00 AM',
        'patient' => 'John Doe',
        'service' => 'General Checkup',
        'doctor' => 'Dr. Sarah Connor',
        'notes' => 'No follow-up required.',
        'result' => 'Healthy',
    ],
    [
        'id' => 2,
        'date' => '2024-12-02',
        'time' => '2:00 PM',
        'patient' => 'Jane Smith',
        'service' => 'Dental Cleaning',
        'doctor' => 'Dr. James Cameron',
        'notes' => 'Suggested annual cleaning.',
        'result' => 'Cleaning completed',
    ],
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
    <meta name="description" content="Finished Appointments - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Finished Appointments | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="finished-appointments-container">
        <div class="appointments-header">
            <h1><?= t('Finished Appointments') ?></h1>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="appointments-table">
            <table>
                <thead>
                    <tr>
                        <th><?= t('Date') ?></th>
                        <th><?= t('Time') ?></th>
                        <th><?= t('Patient') ?></th>
                        <th><?= t('Service') ?></th>
                        <th><?= t('Doctor') ?></th>
                        <th><?= t('Result') ?></th>
                        <th><?= t('Notes') ?></th>
                        <th><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($finishedAppointments)): ?>
                        <?php foreach ($finishedAppointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['date']) ?></td>
                                <td><?= htmlspecialchars($appointment['time']) ?></td>
                                <td><?= htmlspecialchars($appointment['patient']) ?></td>
                                <td><?= htmlspecialchars($appointment['service']) ?></td>
                                <td><?= htmlspecialchars($appointment['doctor']) ?></td>
                                <td><?= htmlspecialchars($appointment['result']) ?></td>
                                <td><?= htmlspecialchars($appointment['notes']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/appointments/<?= $appointment['id'] ?>/view" class="btn btn-view"><?= t('View Details') ?></a>
                                        <a href="/appointments/<?= $appointment['id'] ?>/print" class="btn btn-print"><?= t('Print Report') ?></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8"><?= t('No finished appointments found.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
