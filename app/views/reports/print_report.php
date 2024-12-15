<?php
/**
 * Print Report Template for Clinic Management System
 * Author: Your Name
 * Description: Provides a printable view of the selected report.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Fetch report data dynamically (replace with actual backend data)
$reportTitle = $reportTitle ?? 'Report Title';
$reportData = $reportData ?? [
    ['label' => 'New Patients', 'value' => 50],
    ['label' => 'Temporary Appointments', 'value' => 20],
    ['label' => 'Approved Appointments', 'value' => 30],
    ['label' => 'Completed Appointments', 'value' => 40],
    ['label' => 'Total Income', 'value' => '$5000'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Print Report - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/print.css" media="print">
    <title>Print Report | Clinic Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .report-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .report-header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .report-table th, .report-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .report-table th {
            background-color: #f8f9fa;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <h1><?= htmlspecialchars($reportTitle) ?></h1>
            <p><?= t('Generated on: ') . date('Y-m-d H:i:s') ?></p>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th><?= t('Label') ?></th>
                    <th><?= t('Value') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportData as $data): ?>
                    <tr>
                        <td><?= htmlspecialchars($data['label']) ?></td>
                        <td><?= htmlspecialchars($data['value']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="#" onclick="window.print();" class="print-button"><?= t('Print Report') ?></a>
    </div>
</body>
</html>
