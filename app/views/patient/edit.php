<?php
/**
 * Edit Patient Template for Clinic Management System
 * Author: Your Name
 * Description: Provides a form to edit an existing patient's details.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Fetch patient data dynamically (Replace with real backend data)
$patient = $patient ?? [
    'id' => 1,
    'full_name' => 'John Doe',
    'dob' => '1992-05-15',
    'gender' => 'Male',
    'phone' => '1234567890',
    'address' => '123 Main Street',
    'city' => 'Baghdad'
];

// Cities of Iraq for dropdown (replace with database values if dynamic)
$cities = [
    'Baghdad', 'Basra', 'Mosul', 'Erbil', 'Karbala', 'Najaf', 'Sulaymaniyah', 'Kirkuk',
    'Duhok', 'Ramadi', 'Fallujah', 'Samarra', 'Nasiriyah', 'Amara', 'Diwaniyah'
];

// Display error or success messages (optional)
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit Patient - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Edit Patient | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="edit-patient-container">
        <div class="edit-patient-header">
            <h1><?= t('Edit Patient Details') ?></h1>
        </div>

        <div class="edit-patient-form-container">
            <form action="/patients/<?= $patient['id'] ?>/update" method="POST" class="edit-patient-form">
                <?php if ($error): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="full_name"><?= t('Full Name') ?></label>
                    <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($patient['full_name']) ?>" placeholder="<?= t('Enter patient full name') ?>" required>
                </div>
                <div class="form-group">
                    <label for="dob"><?= t('Date of Birth') ?></label>
                    <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($patient['dob']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender"><?= t('Gender') ?></label>
                    <select name="gender" id="gender" required>
                        <option value=""><?= t('Select Gender') ?></option>
                        <option value="Male" <?= $patient['gender'] === 'Male' ? 'selected' : '' ?>><?= t('Male') ?></option>
                        <option value="Female" <?= $patient['gender'] === 'Female' ? 'selected' : '' ?>><?= t('Female') ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone"><?= t('Phone Number') ?></label>
                    <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($patient['phone']) ?>" placeholder="<?= t('Enter phone number') ?>" required>
                </div>
                <div class="form-group">
                    <label for="address"><?= t('Address') ?></label>
                    <textarea name="address" id="address" rows="3" placeholder="<?= t('Enter address') ?>" required><?= htmlspecialchars($patient['address']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="city"><?= t('City') ?></label>
                    <select name="city" id="city" required>
                        <option value=""><?= t('Select City') ?></option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= htmlspecialchars($city) ?>" <?= $patient['city'] === $city ? 'selected' : '' ?>>
                                <?= htmlspecialchars($city) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= t('Save Changes') ?></button>
                    <a href="/patients" class="btn btn-secondary"><?= t('Cancel') ?></a>
                </div>
            </form>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
