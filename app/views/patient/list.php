<?php
/**
 * Patient List Template for Clinic Management System
 * Author: Your Name
 * Description: Displays a list of patients with search and management options.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$userRole = $_SESSION['user_role'] ?? 'guest';

// Example data - Replace with dynamic data from the backend
$patients = $patients ?? [
    ['id' => 1, 'name' => 'John Doe', 'phone' => '1234567890', 'gender' => 'Male', 'age' => 30],
    ['id' => 2, 'name' => 'Jane Smith', 'phone' => '9876543210', 'gender' => 'Female', 'age' => 25],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Patient List - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Patient List | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="patient-list-container">
        <div class="patient-list-header">
            <h1><?= t('Patient List') ?></h1>
            <div class="patient-list-actions">
                <form action="/patients/search" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="<?= t('Search by name or phone...') ?>" class="search-input">
                    <button type="submit" class="btn btn-search"><?= t('Search') ?></button>
                </form>
                <a href="/patients/add" class="btn btn-primary"><?= t('Add New Patient') ?></a>
            </div>
        </div>

        <div class="patient-list-table">
            <table>
                <thead>
                    <tr>
                        <th><?= t('Name') ?></th>
                        <th><?= t('Phone') ?></th>
                        <th><?= t('Gender') ?></th>
                        <th><?= t('Age') ?></th>
                        <th><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($patients)): ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?= htmlspecialchars($patient['name']) ?></td>
                                <td><?= htmlspecialchars($patient['phone']) ?></td>
                                <td><?= htmlspecialchars($patient['gender']) ?></td>
                                <td><?= htmlspecialchars($patient['age']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/patients/<?= $patient['id'] ?>/view" class="btn btn-view"><?= t('View') ?></a>
                                        <a href="/patients/<?= $patient['id'] ?>/edit" class="btn btn-edit"><?= t('Edit') ?></a>
                                        <form action="/patients/<?= $patient['id'] ?>/delete" method="POST" class="inline-form">
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('<?= t('Are you sure you want to delete this patient?') ?>')"><?= t('Delete') ?></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5"><?= t('No patients found.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
