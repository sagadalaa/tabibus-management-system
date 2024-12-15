<?php
/**
 * Approved Appointments Template for Clinic Management System
 * Author: Your Name
 * Description: Displays and manages approved appointments with options for actions.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example approved appointment data (replace with dynamic backend data)
$approvedAppointments = $approvedAppointments ?? [
    [
        'id' => 1,
        'date' => '2024-12-01',
        'time' => '10:00 AM',
        'patient' => 'John Doe',
        'service' => 'General Checkup',
        'doctor' => 'Dr. Sarah Connor',
        'notes' => 'Follow-up required.',
    ],
    [
        'id' => 2,
        'date' => '2024-12-02',
        'time' => '2:00 PM',
        'patient' => 'Jane Smith',
        'service' => 'Dental Cleaning',
        'doctor' => 'Dr. James Cameron',
        'notes' => 'Patient requested a morning slot.',
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
    <meta name="description" content="Approved Appointments - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Approved Appointments | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="approved-appointments-container">
        <div class="appointments-header">
            <h1><?= t('Approved Appointments') ?></h1>
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
                        <th><?= t('Notes') ?></th>
                        <th><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($approvedAppointments)): ?>
                        <?php foreach ($approvedAppointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['date']) ?></td>
                                <td><?= htmlspecialchars($appointment['time']) ?></td>
                                <td><?= htmlspecialchars($appointment['patient']) ?></td>
                                <td><?= htmlspecialchars($appointment['service']) ?></td>
                                <td><?= htmlspecialchars($appointment['doctor']) ?></td>
                                <td><?= htmlspecialchars($appointment['notes']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <form action="/appointments/<?= $appointment['id'] ?>/start" method="POST" class="inline-form">
                                            <button type="submit" class="btn btn-start"><?= t('Start') ?></button>
                                        </form>
                                        <form action="/appointments/<?= $appointment['id'] ?>/delete" method="POST" class="inline-form">
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('<?= t('Are you sure you want to delete this appointment?') ?>')"><?= t('Delete') ?></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7"><?= t('No approved appointments found.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>