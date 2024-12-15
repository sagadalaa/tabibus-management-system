<?php
/**
 * ReportController for Clinic Management System
 * Author: Your Name
 * Description: Handles report generation for appointments, patients, and financial summaries.
 */

require_once __DIR__ . '/../models/ReportModel.php';
require_once __DIR__ . '/../helpers/functions.php';

class ReportController
{
    private $reportModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
    }

    /**
     * Display the reports page with charts and filters.
     */
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $clinicId = $_SESSION['user_id'];

        // Default report filters (e.g., monthly view)
        $filter = $_GET['filter'] ?? 'monthly';
        $data = $this->generateReportData($clinicId, $filter);

        require __DIR__ . '/../../views/reports/index.php';
    }

    /**
     * Generate report data based on filters (e.g., daily, weekly, monthly).
     *
     * @param int $clinicId The ID of the clinic.
     * @param string $filter The filter type (daily, weekly, monthly).
     * @return array The generated report data.
     */
    private function generateReportData($clinicId, $filter)
    {
        // Fetch data based on the filter type
        $appointmentData = $this->reportModel->getAppointmentsByFilter($clinicId, $filter);
        $patientData = $this->reportModel->getNewPatientsByFilter($clinicId, $filter);
        $incomeData = $this->reportModel->getTotalIncomeByFilter($clinicId, $filter);

        return [
            'appointments' => $appointmentData,
            'patients' => $patientData,
            'income' => $incomeData,
        ];
    }

    /**
     * Generate a detailed printable report.
     */
    public function printReport()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $clinicId = $_SESSION['user_id'];
        $filter = $_GET['filter'] ?? 'monthly';

        $data = $this->generateReportData($clinicId, $filter);

        // Load the printable report view
        require __DIR__ . '/../../views/reports/print_report.php';
    }

    /**
     * Handle AJAX requests to fetch live data for charts.
     */
    public function fetchLiveData()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $clinicId = $_SESSION['user_id'];
        $filter = $_GET['filter'] ?? 'monthly';

        $data = $this->generateReportData($clinicId, $filter);

        echo json_encode($data);
    }
}
