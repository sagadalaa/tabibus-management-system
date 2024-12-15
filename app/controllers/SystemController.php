<?php
/**
 * SystemController for Clinic Management System
 * Author: Your Name
 * Description: Handles clinic system settings (clinic info, receptionists, subscriptions, backups).
 */

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/SubscriptionModel.php';
require_once __DIR__ . '/../helpers/functions.php';

class SystemController
{
    private $userModel;
    private $subscriptionModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->subscriptionModel = new SubscriptionModel();
    }

    /**
     * Display the system settings page.
     */
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'clinic_admin') {
            redirect('/login');
        }

        $clinicId = $_SESSION['user_id'];

        // Fetch clinic info, receptionists, and subscription details
        $clinicInfo = $this->userModel->getClinicInfo($clinicId);
        $receptionists = $this->userModel->getReceptionistsByClinic($clinicId);
        $subscription = $this->subscriptionModel->getActiveSubscription($clinicId);

        require __DIR__ . '/../../views/system/index.php';
    }

    /**
     * Update clinic information.
     */
    public function updateClinicInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'clinic_admin') {
                redirect('/login');
            }

            $clinicId = $_SESSION['user_id'];
            $clinicName = trim($_POST['clinic_name']);
            $address = trim($_POST['address']);
            $phone = trim($_POST['phone']);
            $socialLinks = $_POST['social_links'];

            // Validate inputs
            if (empty($clinicName) || empty($address) || empty($phone)) {
                $error = 'All fields are required.';
                $this->index();
                return;
            }

            // Update clinic info in the database
            $this->userModel->updateClinicInfo($clinicId, [
                'clinic_name' => $clinicName,
                'address' => $address,
                'phone' => $phone,
                'social_links' => $socialLinks,
            ]);

            redirect('/system');
        }
    }

    /**
     * Manage receptionists (add, edit, enable/disable, delete).
     */
    public function manageReceptionists()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'clinic_admin') {
                redirect('/login');
            }

            $action = $_POST['action'];
            $receptionistId = $_POST['receptionist_id'] ?? null;

            switch ($action) {
                case 'add':
                    $username = trim($_POST['username']);
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    // Validate inputs
                    if (empty($username) || empty($_POST['password'])) {
                        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
                        return;
                    }

                    // Add receptionist
                    $this->userModel->createReceptionist($_SESSION['user_id'], $username, $password);
                    echo json_encode(['success' => true, 'message' => 'Receptionist added successfully.']);
                    break;

                case 'update':
                    $username = trim($_POST['username']);
                    $password = empty($_POST['password']) ? null : password_hash($_POST['password'], PASSWORD_BCRYPT);

                    // Update receptionist info
                    $this->userModel->updateReceptionist($receptionistId, $username, $password);
                    echo json_encode(['success' => true, 'message' => 'Receptionist updated successfully.']);
                    break;

                case 'toggle_status':
                    $status = $_POST['status'] === 'enable' ? 1 : 0;
                    $this->userModel->toggleReceptionistStatus($receptionistId, $status);
                    echo json_encode(['success' => true, 'message' => 'Receptionist status updated.']);
                    break;

                case 'delete':
                    $this->userModel->deleteReceptionist($receptionistId);
                    echo json_encode(['success' => true, 'message' => 'Receptionist deleted.']);
                    break;

                default:
                    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            }
        }
    }

    /**
     * Update appointment limits.
     */
    public function updateAppointmentLimits()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'clinic_admin') {
                redirect('/login');
            }

            $clinicId = $_SESSION['user_id'];
            $limits = $_POST['appointment_limits'];

            // Update appointment limits in the database
            $this->userModel->updateAppointmentLimits($clinicId, $limits);

            echo json_encode(['success' => true, 'message' => 'Appointment limits updated successfully.']);
        }
    }

    /**
     * Handle backup and restore functionality.
     */
    public function backupRestore()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'clinic_admin') {
            redirect('/login');
        }

        $action = $_POST['action'] ?? '';

        if ($action === 'backup') {
            // Generate a database backup
            $backupFile = $this->userModel->createBackup();
            echo json_encode(['success' => true, 'message' => 'Backup created successfully.', 'file' => $backupFile]);
        } elseif ($action === 'restore') {
            // Handle restore process
            if (isset($_FILES['backup_file']) && $_FILES['backup_file']['error'] === UPLOAD_ERR_OK) {
                $this->userModel->restoreBackup($_FILES['backup_file']['tmp_name']);
                echo json_encode(['success' => true, 'message' => 'Backup restored successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error uploading backup file.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        }
    }
}
