<?php
/**
 * ReportModel for Clinic Management System
 * Author: Your Name
 * Description: Handles database interactions for generating reports.
 */

class ReportModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get appointment statistics filtered by a specific period (daily, weekly, monthly).
     *
     * @param int $clinicId
     * @param string $filter
     * @return array
     */
    public function getAppointmentsByFilter($clinicId, $filter)
    {
        $dateFilter = $this->getDateFilter($filter);

        $stmt = $this->db->prepare("
            SELECT status, COUNT(*) AS count
            FROM appointments
            WHERE clinic_id = :clinicId AND appointment_date >= :startDate
            GROUP BY status
        ");
        $stmt->execute([
            'clinicId' => $clinicId,
            'startDate' => $dateFilter,
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Get new patient statistics filtered by a specific period.
     *
     * @param int $clinicId
     * @param string $filter
     * @return int
     */
    public function getNewPatientsByFilter($clinicId, $filter)
    {
        $dateFilter = $this->getDateFilter($filter);

        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS count
            FROM patients
            WHERE clinic_id = :clinicId AND created_at >= :startDate
        ");
        $stmt->execute([
            'clinicId' => $clinicId,
            'startDate' => $dateFilter,
        ]);

        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }

    /**
     * Get total income statistics filtered by a specific period.
     *
     * @param int $clinicId
     * @param string $filter
     * @return float
     */
    public function getTotalIncomeByFilter($clinicId, $filter)
    {
        $dateFilter = $this->getDateFilter($filter);

        $stmt = $this->db->prepare("
            SELECT SUM(price) AS total_income
            FROM appointments
            JOIN services ON appointments.service_id = services.id
            WHERE appointments.clinic_id = :clinicId AND appointments.appointment_date >= :startDate
        ");
        $stmt->execute([
            'clinicId' => $clinicId,
            'startDate' => $dateFilter,
        ]);

        $result = $stmt->fetch();
        return $result['total_income'] ?? 0.0;
    }

    /**
     * Generate a date filter based on the provided period (daily, weekly, monthly).
     *
     * @param string $filter
     * @return string
     */
    private function getDateFilter($filter)
    {
        switch ($filter) {
            case 'daily':
                return date('Y-m-d', strtotime('-1 day'));
            case 'weekly':
                return date('Y-m-d', strtotime('-7 days'));
            case 'monthly':
                return date('Y-m-d', strtotime('-30 days'));
            default:
                throw new InvalidArgumentException("Invalid filter type: $filter");
        }
    }
}
