<?php
/**
 * PatientController for Clinic Management System
 * Author: Your Name
 * Description: Handles patient management (list, add, edit, delete).
 */

require_once __DIR__ . '/../models/PatientModel.php';
require_once __DIR__ . '/../helpers/functions.php';

class PatientController
{
    private $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    /**
     * List all patients for the current clinic admin.
     */
    public function list()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $clinicId = $_SESSION['user_id'];
        $patients = $this->patientModel->getPatientsByClinic($clinicId);

        require __DIR__ . '/../../views/patient/list.php';
    }

    /**
     * Show the form to add a new patient.
     */
    public function addForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        require __DIR__ . '/../../views/patient/add.php';
    }

    /**
     * Handle adding a new patient.
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $clinicId = $_SESSION['user_id'];
            $fullName = trim($_POST['full_name']);
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $city = $_POST['city'];

            // Validate inputs
            if (empty($fullName) || empty($dob) || empty($gender) || empty($phone) || empty($address) || empty($city)) {
                $error = 'All fields are required.';
                require __DIR__ . '/../../views/patient/add.php';
                return;
            }

            // Add the patient to the database
            $this->patientModel->create([
                'clinic_id' => $clinicId,
                'full_name' => $fullName,
                'dob' => $dob,
                'gender' => $gender,
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
            ]);

            redirect('/patients');
        }
    }

    /**
     * Show the form to edit an existing patient.
     */
    public function editForm($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $patient = $this->patientModel->findById($id);

        if (!$patient) {
            http_response_code(404);
            echo "Patient not found.";
            return;
        }

        require __DIR__ . '/../../views/patient/edit.php';
    }

    /**
     * Handle updating a patient's information.
     */
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $patientId = $_POST['patient_id'];
            $fullName = trim($_POST['full_name']);
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $city = $_POST['city'];

            // Validate inputs
            if (empty($fullName) || empty($dob) || empty($gender) || empty($phone) || empty($address) || empty($city)) {
                $error = 'All fields are required.';
                $patient = $this->patientModel->findById($patientId);
                require __DIR__ . '/../../views/patient/edit.php';
                return;
            }

            // Update the patient's information
            $this->patientModel->update($patientId, [
                'full_name' => $fullName,
                'dob' => $dob,
                'gender' => $gender,
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
            ]);

            redirect('/patients');
        }
    }

    /**
     * Handle deleting a patient.
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $patientId = $_POST['patient_id'];

            // Validate input
            if (empty($patientId)) {
                echo json_encode(['success' => false, 'message' => 'Invalid patient ID.']);
                return;
            }

            // Delete the patient
            $this->patientModel->delete($patientId);

            echo json_encode(['success' => true, 'message' => 'Patient deleted successfully.']);
        }
    }
}
