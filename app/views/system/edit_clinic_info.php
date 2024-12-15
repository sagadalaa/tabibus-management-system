<?php
/**
 * Edit Clinic Information Template for Clinic Management System
 * Author: Your Name
 * Description: Provides a form to update clinic information.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example clinic information (replace with dynamic backend data)
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
    <meta name="description" content="Edit Clinic Information - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Edit Clinic Information | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="edit-clinic-info-container">
        <div class="edit-clinic-header">
            <h1><?= t('Edit Clinic Information') ?></h1>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form action="/system/clinic-info/update" method="POST" class="edit-clinic-form">
            <div class="form-group">
                <label for="clinic_name"><?= t('Clinic Name') ?></label>
                <input type="text" name="clinic_name" id="clinic_name" value="<?= htmlspecialchars($clinicInfo['name']) ?>" placeholder="<?= t('Enter clinic name') ?>" required>
            </div>
            <div class="form-group">
                <label for="clinic_address"><?= t('Address') ?></label>
                <textarea name="clinic_address" id="clinic_address" rows="3" placeholder="<?= t('Enter clinic address') ?>" required><?= htmlspecialchars($clinicInfo['address']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="clinic_phone"><?= t('Phone') ?></label>
                <input type="tel" name="clinic_phone" id="clinic_phone" value="<?= htmlspecialchars($clinicInfo['phone']) ?>" placeholder="<?= t('Enter phone number') ?>" required>
            </div>
            <div class="form-group">
                <label for="clinic_email"><?= t('Email') ?></label>
                <input type="email" name="clinic_email" id="clinic_email" value="<?= htmlspecialchars($clinicInfo['email']) ?>" placeholder="<?= t('Enter email address') ?>" required>
            </div>
            <div class="form-group">
                <label for="clinic_social_links"><?= t('Social Links') ?></label>
                <input type="url" name="social_links[facebook]" value="<?= htmlspecialchars($clinicInfo['social_links']['facebook']) ?>" placeholder="Facebook">
                <input type="url" name="social_links[twitter]" value="<?= htmlspecialchars($clinicInfo['social_links']['twitter']) ?>" placeholder="Twitter">
                <input type="url" name="social_links[instagram]" value="<?= htmlspecialchars($clinicInfo['social_links']['instagram']) ?>" placeholder="Instagram">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?= t('Save Changes') ?></button>
                <a href="/system" class="btn btn-secondary"><?= t('Cancel') ?></a>
            </div>
        </form>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
