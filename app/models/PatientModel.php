<?php
/**
 * PatientModel for Clinic Management System
 * Author: Your Name
 * Description: Handles database interactions for patient-related data.
 */

class PatientModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all patients for a specific clinic.
     *
     * @param int $clinicId
     * @return array
     */
    public function getPatientsByClinic($clinicId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM patients WHERE clinic_id = :clinicId ORDER BY created_at DESC
        ");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetchAll();
    }

    /**
     * Find a patient by ID.
     *
     * @param int $patientId
     * @return array|null
     */
    public function findById($patientId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM patients WHERE id = :patientId LIMIT 1
        ");
        $stmt->execute(['patientId' => $patientId]);
        return $stmt->fetch();
    }

    /**
     * Create a new patient record.
     *
     * @param array $patientData
     * @return int The ID of the newly created patient.
     */
    public function create($patientData)
    {
        $stmt = $this->db->prepare("
            INSERT INTO patients (clinic_id, full_name, dob, gender, phone, address, city, created_at)
            VALUES (:clinic_id, :full_name, :dob, :gender, :phone, :address, :city, NOW())
        ");
        $stmt->execute([
            'clinic_id' => $patientData['clinic_id'],
            'full_name' => $patientData['full_name'],
            'dob' => $patientData['dob'],
            'gender' => $patientData['gender'],
            'phone' => $patientData['phone'],
            'address' => $patientData['address'],
            'city' => $patientData['city'],
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update an existing patient record.
     *
     * @param int $patientId
     * @param array $patientData
     * @return bool
     */
    public function update($patientId, $patientData)
    {
        $stmt = $this->db->prepare("
            UPDATE patients 
            SET full_name = :full_name, dob = :dob, gender = :gender, phone = :phone, 
                address = :address, city = :city
            WHERE id = :patientId
        ");
        return $stmt->execute([
            'full_name' => $patientData['full_name'],
            'dob' => $patientData['dob'],
            'gender' => $patientData['gender'],
            'phone' => $patientData['phone'],
            'address' => $patientData['address'],
            'city' => $patientData['city'],
            'patientId' => $patientId,
        ]);
    }

    /**
     * Delete a patient record by ID.
     *
     * @param int $patientId
     * @return bool
     */
    public function delete($patientId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM patients WHERE id = :patientId
        ");
        return $stmt->execute(['patientId' => $patientId]);
    }

    /**
     * Search for patients by name or phone within a clinic.
     *
     * @param int $clinicId
     * @param string $searchTerm
     * @return array
     */
    public function searchPatients($clinicId, $searchTerm)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM patients 
            WHERE clinic_id = :clinicId AND (full_name LIKE :searchTerm OR phone LIKE :searchTerm)
            ORDER BY created_at DESC
        ");
        $stmt->execute([
            'clinicId' => $clinicId,
            'searchTerm' => '%' . $searchTerm . '%',
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Get the full history of appointments for a specific patient.
     *
     * @param int $patientId
     * @return array
     */
    public function getAppointmentHistory($patientId)
    {
        $stmt = $this->db->prepare("
            SELECT a.*, s.name AS service_name
            FROM appointments a
            LEFT JOIN services s ON a.service_id = s.id
            WHERE a.patient_id = :patientId
            ORDER BY a.appointment_date DESC
        ");
        $stmt->execute(['patientId' => $patientId]);
        return $stmt->fetchAll();
    }
}
