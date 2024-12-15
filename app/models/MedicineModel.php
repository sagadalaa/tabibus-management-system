<?php
/**
 * MedicineModel for Clinic Management System
 * Author: Your Name
 * Description: Handles database interactions for medicine-related data.
 */

class MedicineModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all medicines for a specific clinic.
     *
     * @param int $clinicId
     * @return array
     */
    public function getMedicinesByClinic($clinicId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM medicines WHERE clinic_id = :clinicId ORDER BY created_at DESC
        ");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetchAll();
    }

    /**
     * Find a medicine by ID.
     *
     * @param int $medicineId
     * @return array|null
     */
    public function findById($medicineId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM medicines WHERE id = :medicineId LIMIT 1
        ");
        $stmt->execute(['medicineId' => $medicineId]);
        return $stmt->fetch();
    }

    /**
     * Create a new medicine record.
     *
     * @param array $medicineData
     * @return int The ID of the newly created medicine.
     */
    public function create($medicineData)
    {
        $stmt = $this->db->prepare("
            INSERT INTO medicines (clinic_id, name, size, usage, created_at)
            VALUES (:clinic_id, :name, :size, :usage, NOW())
        ");
        $stmt->execute([
            'clinic_id' => $medicineData['clinic_id'],
            'name' => $medicineData['name'],
            'size' => $medicineData['size'],
            'usage' => $medicineData['usage'],
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update an existing medicine record.
     *
     * @param int $medicineId
     * @param array $medicineData
     * @return bool
     */
    public function update($medicineId, $medicineData)
    {
        $stmt = $this->db->prepare("
            UPDATE medicines 
            SET name = :name, size = :size, usage = :usage
            WHERE id = :medicineId
        ");
        return $stmt->execute([
            'name' => $medicineData['name'],
            'size' => $medicineData['size'],
            'usage' => $medicineData['usage'],
            'medicineId' => $medicineId,
        ]);
    }

    /**
     * Delete a medicine record by ID.
     *
     * @param int $medicineId
     * @return bool
     */
    public function delete($medicineId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM medicines WHERE id = :medicineId
        ");
        return $stmt->execute(['medicineId' => $medicineId]);
    }

    /**
     * Search for medicines by name within a clinic.
     *
     * @param int $clinicId
     * @param string $searchTerm
     * @return array
     */
    public function searchMedicines($clinicId, $searchTerm)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM medicines 
            WHERE clinic_id = :clinicId AND name LIKE :searchTerm
            ORDER BY created_at DESC
        ");
        $stmt->execute([
            'clinicId' => $clinicId,
            'searchTerm' => '%' . $searchTerm . '%',
        ]);
        return $stmt->fetchAll();
    }
}
