<?php
/**
 * System Settings Template for Clinic Management System
 * Author: Your Name
 * Description: Displays and manages clinic system settings.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example data for the system settings (replace with actual backend data)
$clinicInfo = $clinicInfo ?? [
    'name' => 'Health First Clinic',
    'address' => '123 Main Street, Cityville',
    'phone' => '123-456-7890',
    'email' => 'clinic@example.com',
    'social_links' => [
        'facebook' => 'https://facebook.com/clinic',
        'twitter' => 'https://twitter.com/clinic',
        'instagram' => 'https://instagram.com/clinic',
    ],
    'currency' => 'USD',
    'appointment_limits' => [
        'temporary' => 10,
        'approved' => 20,
        'completed' => 30,
    ],
    'license' => [
        'active' => true,
        'expiry_date' => '2025-12-31',
        'price' => '500.00',
        'paid' => true,
    ],
    'support' => [
        'email' => 'support@clinic.com',
        'phone' => '555-123-4567',
    ],
];

// Error or success messages
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="System Settings - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>System Settings | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="system-settings-container">
        <div class="system-header">
            <h1><?= t('System Settings') ?></h1>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="system-section">
            <h2><?= t('Clinic Information') ?></h2>
            <form action="/system/clinic-info/update" method="POST">
                <div class="form-group">
                    <label for="clinic_name"><?= t('Clinic Name') ?></label>
                    <input type="text" name="clinic_name" id="clinic_name" value="<?= htmlspecialchars($clinicInfo['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="clinic_address"><?= t('Address') ?></label>
                    <textarea name="clinic_address" id="clinic_address" rows="2" required><?= htmlspecialchars($clinicInfo['address']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="clinic_phone"><?= t('Phone') ?></label>
                    <input type="tel" name="clinic_phone" id="clinic_phone" value="<?= htmlspecialchars($clinicInfo['phone']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="clinic_email"><?= t('Email') ?></label>
                    <input type="email" name="clinic_email" id="clinic_email" value="<?= htmlspecialchars($clinicInfo['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="clinic_social_links"><?= t('Social Links') ?></label>
                    <input type="url" name="social_links[facebook]" value="<?= htmlspecialchars($clinicInfo['social_links']['facebook']) ?>" placeholder="Facebook">
                    <input type="url" name="social_links[twitter]" value="<?= htmlspecialchars($clinicInfo['social_links']['twitter']) ?>" placeholder="Twitter">
                    <input type="url" name="social_links[instagram]" value="<?= htmlspecialchars($clinicInfo['social_links']['instagram']) ?>" placeholder="Instagram">
                </div>
                <button type="submit" class="btn btn-primary"><?= t('Save Changes') ?></button>
            </form>
        </div>

        <div class="system-section">
            <h2><?= t('Currency and Appointment Limits') ?></h2>
            <form action="/system/settings/update" method="POST">
                <div class="form-group">
                    <label for="currency"><?= t('Currency') ?></label>
                    <input type="text" name="currency" id="currency" value="<?= htmlspecialchars($clinicInfo['currency']) ?>" required>
                </div>
                <div class="form-group">
                    <label><?= t('Appointment Limits') ?></label>
                    <input type="number" name="appointment_limits[temporary]" value="<?= htmlspecialchars($clinicInfo['appointment_limits']['temporary']) ?>" placeholder="<?= t('Temporary Appointments') ?>" required>
                    <input type="number" name="appointment_limits[approved]" value="<?= htmlspecialchars($clinicInfo['appointment_limits']['approved']) ?>" placeholder="<?= t('Approved Appointments') ?>" required>
                    <input type="number" name="appointment_limits[completed]" value="<?= htmlspecialchars($clinicInfo['appointment_limits']['completed']) ?>" placeholder="<?= t('Completed Appointments') ?>" required>
                </div>
                <button type="submit" class="btn btn-primary"><?= t('Save Changes') ?></button>
            </form>
        </div>

        <div class="system-section">
            <h2><?= t('License Information') ?></h2>
            <p><?= t('Active: ') . ($clinicInfo['license']['active'] ? t('Yes') : t('No')) ?></p>
            <p><?= t('Expiry Date: ') . htmlspecialchars($clinicInfo['license']['expiry_date']) ?></p>
            <p><?= t('Price: $') . htmlspecialchars($clinicInfo['license']['price']) ?></p>
            <p><?= t('Paid: ') . ($clinicInfo['license']['paid'] ? t('Yes') : t('No')) ?></p>
        </div>

        <div class="system-section">
            <h2><?= t('Support Information') ?></h2>
            <p><?= t('Email: ') . htmlspecialchars($clinicInfo['support']['email']) ?></p>
            <p><?= t('Phone: ') . htmlspecialchars($clinicInfo['support']['phone']) ?></p>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
