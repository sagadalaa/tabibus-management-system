<?php
/**
 * ServiceController for Clinic Management System
 * Author: Your Name
 * Description: Manages services and medicines (list, add, edit, delete).
 */

require_once __DIR__ . '/../models/ServiceModel.php';
require_once __DIR__ . '/../models/MedicineModel.php';
require_once __DIR__ . '/../helpers/functions.php';

class ServiceController
{
    private $serviceModel;
    private $medicineModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->medicineModel = new MedicineModel();
    }

    /**
     * List all services and medicines for the current clinic.
     */
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $clinicId = $_SESSION['user_id'];
        $services = $this->serviceModel->getServicesByClinic($clinicId);
        $medicines = $this->medicineModel->getMedicinesByClinic($clinicId);

        require __DIR__ . '/../../views/services/index.php';
    }

    /**
     * Show the form to add a new service.
     */
    public function addServiceForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        require __DIR__ . '/../../views/services/add_service.php';
    }

    /**
     * Handle adding a new service.
     */
    public function addService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $clinicId = $_SESSION['user_id'];
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);

            // Validate inputs
            if (empty($name) || empty($price)) {
                $error = 'All fields are required.';
                require __DIR__ . '/../../views/services/add_service.php';
                return;
            }

            // Add the service to the database
            $this->serviceModel->create([
                'clinic_id' => $clinicId,
                'name' => $name,
                'price' => $price,
            ]);

            redirect('/services');
        }
    }

    /**
     * Show the form to edit an existing service.
     */
    public function editServiceForm($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $service = $this->serviceModel->findById($id);

        if (!$service) {
            http_response_code(404);
            echo "Service not found.";
            return;
        }

        require __DIR__ . '/../../views/services/edit_service.php';
    }

    /**
     * Handle updating a service.
     */
    public function editService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $serviceId = $_POST['service_id'];
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);

            // Validate inputs
            if (empty($name) || empty($price)) {
                $error = 'All fields are required.';
                $service = $this->serviceModel->findById($serviceId);
                require __DIR__ . '/../../views/services/edit_service.php';
                return;
            }

            // Update the service
            $this->serviceModel->update($serviceId, [
                'name' => $name,
                'price' => $price,
            ]);

            redirect('/services');
        }
    }

    /**
     * Handle deleting a service.
     */
    public function deleteService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $serviceId = $_POST['service_id'];

            // Validate input
            if (empty($serviceId)) {
                echo json_encode(['success' => false, 'message' => 'Invalid service ID.']);
                return;
            }

            // Delete the service
            $this->serviceModel->delete($serviceId);

            echo json_encode(['success' => true, 'message' => 'Service deleted successfully.']);
        }
    }

    /**
     * Show the form to add a new medicine.
     */
    public function addMedicineForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        require __DIR__ . '/../../views/services/add_medicine.php';
    }

    /**
     * Handle adding a new medicine.
     */
    public function addMedicine()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }

            $clinicId = $_SESSION['user_id'];
            $name = trim($_POST['name']);
            $size = trim($_POST['size']);
            $usage = trim($_POST['usage']);

            // Validate inputs
            if (empty($name) || empty($size) || empty($usage)) {
                $error = 'All fields are required.';
                require __DIR__ . '/../../views/services/add_medicine.php';
                return;
            }

            // Add the medicine to the database
            $this->medicineModel->create([
                'clinic_id' => $clinicId,
                'name' => $name,
                'size' => $size,
                'usage' => $usage,
            ]);

            redirect('/services');
        }
    }
}
