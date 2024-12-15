<?php
/**
 * Patient History Template for Clinic Management System
 * Author: Your Name
 * Description: Displays the history of appointments and treatments for a specific patient.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example patient and appointment data (replace with dynamic backend data)
$patient = $patient ?? [
    'id' => 1,
    'full_name' => 'John Doe',
    'phone' => '1234567890',
    'gender' => 'Male',
    'age' => 30,
];

$appointments = $appointments ?? [
    [
        'date' => '2024-12-01',
        'service' => 'General Checkup',
        'doctor' => 'Dr. Sarah Connor',
        'notes' => 'Regular checkup. No issues found.',
        'status' => 'Completed',
    ],
    [
        'date' => '2024-11-15',
        'service' => 'Dental Cleaning',
        'doctor' => 'Dr. James Cameron',
        'notes' => 'Teeth cleaning procedure.',
        'status' => 'Completed',
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Patient History - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Patient History | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="patient-history-container">
        <div class="patient-header">
            <h1><?= t('Patient History') ?></h1>
            <div class="patient-details">
                <p><strong><?= t('Name:') ?></strong> <?= htmlspecialchars($patient['full_name']) ?></p>
                <p><strong><?= t('Phone:') ?></strong> <?= htmlspecialchars($patient['phone']) ?></p>
                <p><strong><?= t('Gender:') ?></strong> <?= htmlspecialchars($patient['gender']) ?></p>
                <p><strong><?= t('Age:') ?></strong> <?= htmlspecialchars($patient['age']) ?></p>
            </div>
        </div>

        <div class="appointment-history">
            <h2><?= t('Appointment History') ?></h2>
            <table>
                <thead>
                    <tr>
                        <th><?= t('Date') ?></th>
                        <th><?= t('Service') ?></th>
                        <th><?= t('Doctor') ?></th>
                        <th><?= t('Notes') ?></th>
                        <th><?= t('Status') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['date']) ?></td>
                                <td><?= htmlspecialchars($appointment['service']) ?></td>
                                <td><?= htmlspecialchars($appointment['doctor']) ?></td>
                                <td><?= htmlspecialchars($appointment['notes']) ?></td>
                                <td><?= htmlspecialchars($appointment['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5"><?= t('No appointments found.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
