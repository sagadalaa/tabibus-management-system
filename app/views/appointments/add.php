<?php
/**
 * Add Appointment Template for Clinic Management System
 * Author: Your Name
 * Description: Provides a form to schedule a new appointment.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example patient and service data (replace with dynamic backend data)
$patients = $patients ?? [
    ['id' => 1, 'name' => 'John Doe'],
    ['id' => 2, 'name' => 'Jane Smith'],
];

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
    <meta name="description" content="Add Appointment - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Add Appointment | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="add-appointment-container">
        <div class="add-appointment-header">
            <h1><?= t('Add New Appointment') ?></h1>
        </div>

        <div class="add-appointment-form-container">
            <form action="/appointments/create" method="POST" class="add-appointment-form">
                <?php if ($error): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="patient_id"><?= t('Patient') ?></label>
                    <select name="patient_id" id="patient_id" required>
                        <option value=""><?= t('Select Patient') ?></option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?= htmlspecialchars($patient['id']) ?>"><?= htmlspecialchars($patient['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="service_id"><?= t('Service') ?></label>
                    <select name="service_id" id="service_id" required>
                        <option value=""><?= t('Select Service') ?></option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= htmlspecialchars($service['id']) ?>"><?= htmlspecialchars($service['name']) ?> ($<?= htmlspecialchars($service['price']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="appointment_date"><?= t('Date') ?></label>
                    <input type="date" name="appointment_date" id="appointment_date" required>
                </div>
                <div class="form-group">
                    <label for="appointment_time"><?= t('Time') ?></label>
                    <input type="time" name="appointment_time" id="appointment_time" required>
                </div>
                <div class="form-group">
                    <label for="notes"><?= t('Notes (Optional)') ?></label>
                    <textarea name="notes" id="notes" rows="3" placeholder="<?= t('Add any additional notes...') ?>"></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= t('Add Appointment') ?></button>
                    <a href="/appointments" class="btn btn-secondary"><?= t('Cancel') ?></a>
                </div>
            </form>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
