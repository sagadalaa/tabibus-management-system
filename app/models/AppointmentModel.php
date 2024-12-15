<?php
/**
 * AppointmentModel for Clinic Management System
 * Author: Your Name
 * Description: Handles database interactions for appointment-related data.
 */

class AppointmentModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all appointments for a specific clinic.
     *
     * @param int $clinicId
     * @return array
     */
    public function getAppointmentsByClinic($clinicId)
    {
        $stmt = $this->db->prepare("
            SELECT a.*, p.full_name AS patient_name, s.name AS service_name
            FROM appointments a
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN services s ON a.service_id = s.id
            WHERE a.clinic_id = :clinicId
            ORDER BY a.appointment_date, a.appointment_time
        ");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetchAll();
    }

    /**
     * Get appointments filtered by status for a clinic.
     *
     * @param int $clinicId
     * @param string $status
     * @return array
     */
    public function getAppointmentsByStatus($clinicId, $status)
    {
        $stmt = $this->db->prepare("
            SELECT a.*, p.full_name AS patient_name, s.name AS service_name
            FROM appointments a
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN services s ON a.service_id = s.id
            WHERE a.clinic_id = :clinicId AND a.status = :status
            ORDER BY a.appointment_date, a.appointment_time
        ");
        $stmt->execute(['clinicId' => $clinicId, 'status' => $status]);
        return $stmt->fetchAll();
    }

    /**
     * Find an appointment by ID.
     *
     * @param int $appointmentId
     * @return array|null
     */
    public function findById($appointmentId)
    {
        $stmt = $this->db->prepare("
            SELECT a.*, p.full_name AS patient_name, s.name AS service_name
            FROM appointments a
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN services s ON a.service_id = s.id
            WHERE a.id = :appointmentId
            LIMIT 1
        ");
        $stmt->execute(['appointmentId' => $appointmentId]);
        return $stmt->fetch();
    }

    /**
     * Create a new appointment record.
     *
     * @param array $appointmentData
     * @return int The ID of the newly created appointment.
     */
    public function create($appointmentData)
    {
        $stmt = $this->db->prepare("
            INSERT INTO appointments (clinic_id, patient_id, service_id, appointment_date, appointment_time, status, notes, created_at)
            VALUES (:clinic_id, :patient_id, :service_id, :appointment_date, :appointment_time, :status, :notes, NOW())
        ");
        $stmt->execute([
            'clinic_id' => $appointmentData['clinic_id'],
            'patient_id' => $appointmentData['patient_id'],
            'service_id' => $appointmentData['service_id'],
            'appointment_date' => $appointmentData['appointment_date'],
            'appointment_time' => $appointmentData['appointment_time'],
            'status' => $appointmentData['status'],
            'notes' => $appointmentData['notes'],
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update an existing appointment record.
     *
     * @param int $appointmentId
     * @param array $appointmentData
     * @return bool
     */
    public function update($appointmentId, $appointmentData)
    {
        $stmt = $this->db->prepare("
            UPDATE appointments 
            SET patient_id = :patient_id, service_id = :service_id, appointment_date = :appointment_date, 
                appointment_time = :appointment_time, status = :status, notes = :notes
            WHERE id = :appointmentId
        ");
        return $stmt->execute([
            'patient_id' => $appointmentData['patient_id'],
            'service_id' => $appointmentData['service_id'],
            'appointment_date' => $appointmentData['appointment_date'],
            'appointment_time' => $appointmentData['appointment_time'],
            'status' => $appointmentData['status'],
            'notes' => $appointmentData['notes'],
            'appointmentId' => $appointmentId,
        ]);
    }

    /**
     * Update the status of an appointment.
     *
     * @param int $appointmentId
     * @param string $status
     * @return bool
     */
    public function updateStatus($appointmentId, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE appointments 
            SET status = :status 
            WHERE id = :appointmentId
        ");
        return $stmt->execute(['status' => $status, 'appointmentId' => $appointmentId]);
    }

    /**
     * Delete an appointment record by ID.
     *
     * @param int $appointmentId
     * @return bool
     */
    public function delete($appointmentId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM appointments WHERE id = :appointmentId
        ");
        return $stmt->execute(['appointmentId' => $appointmentId]);
    }

    /**
     * Get appointment count by status for a clinic.
     *
     * @param int $clinicId
     * @param string $status
     * @return int
     */
    public function getCountByStatus($clinicId, $status)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM appointments 
            WHERE clinic_id = :clinicId AND status = :status
        ");
        $stmt->execute(['clinicId' => $clinicId, 'status' => $status]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
}
