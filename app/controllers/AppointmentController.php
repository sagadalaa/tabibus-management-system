<?php
/**
 * AppointmentController for Clinic Management System
 * Author: Your Name
 * Description: Handles appointment management (list, create, update, delete).
 */

require_once __DIR__ . '/../models/AppointmentModel.php';
require_once __DIR__ . '/../helpers/functions.php';

class AppointmentController
{
    private $appointmentModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
    }

    /**
     * List all appointments for the current user (filtered by role).
     */
    public function list()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $userRole = $_SESSION['user_role'];

        // Fetch appointments based on the user role
        if ($userRole === 'clinic_admin' || $userRole === 'receptionist') {
            $appointments = $this->appointmentModel->getAppointmentsByClinic($userId);
        } else {
            // Add more roles if needed
            $appointments = [];
        }

        require __DIR__ . '/../../views/appointments/list.php';
    }

    /**
     * Show the form to create a new appointment.
     */
    public function createForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        require __DIR__ . '/../../views/appointments/add.php';
    }

    /**
     * Handle creating a new appointment.
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $clinicId = $_SESSION['user_id'];
            $patientId = $_POST['patient_id'];
            $appointmentDate = $_POST['appointment_date'];
            $appointmentTime = $_POST['appointment_time'];
            $service = $_POST['service'];
            $notes = $_POST['notes'];

            // Validate inputs
            if (empty($patientId) || empty($appointmentDate) || empty($appointmentTime) || empty($service)) {
                $error = 'All fields are required.';
                require __DIR__ . '/../../views/appointments/add.php';
                return;
            }

            // Add appointment to the database
            $this->appointmentModel->create([
                'clinic_id' => $clinicId,
                'patient_id' => $patientId,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $appointmentTime,
                'service' => $service,
                'notes' => $notes,
                'status' => 'temporary', // Default status
            ]);

            redirect('/appointments');
        }
    }

    /**
     * Update the status of an appointment.
     */
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $appointmentId = $_POST['appointment_id'];
            $newStatus = $_POST['status'];

            // Validate input
            if (empty($appointmentId) || empty($newStatus)) {
                echo json_encode(['success' => false, 'message' => 'Invalid input.']);
                return;
            }

            // Update the status
            $this->appointmentModel->updateStatus($appointmentId, $newStatus);

            echo json_encode(['success' => true, 'message' => 'Appointment status updated successfully.']);
        }
    }

    /**
     * Delete an appointment.
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $appointmentId = $_POST['appointment_id'];

            // Validate input
            if (empty($appointmentId)) {
                echo json_encode(['success' => false, 'message' => 'Invalid appointment ID.']);
                return;
            }

            // Delete the appointment
            $this->appointmentModel->delete($appointmentId);

            echo json_encode(['success' => true, 'message' => 'Appointment deleted successfully.']);
        }
    }
}
