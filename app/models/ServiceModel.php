<?php
/**
 * ServiceModel for Clinic Management System
 * Author: Your Name
 * Description: Handles database interactions for service-related data.
 */

class ServiceModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all services for a specific clinic.
     *
     * @param int $clinicId
     * @return array
     */
    public function getServicesByClinic($clinicId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM services WHERE clinic_id = :clinicId ORDER BY created_at DESC
        ");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetchAll();
    }

    /**
     * Find a service by ID.
     *
     * @param int $serviceId
     * @return array|null
     */
    public function findById($serviceId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM services WHERE id = :serviceId LIMIT 1
        ");
        $stmt->execute(['serviceId' => $serviceId]);
        return $stmt->fetch();
    }

    /**
     * Create a new service record.
     *
     * @param array $serviceData
     * @return int The ID of the newly created service.
     */
    public function create($serviceData)
    {
        $stmt = $this->db->prepare("
            INSERT INTO services (clinic_id, name, price, created_at)
            VALUES (:clinic_id, :name, :price, NOW())
        ");
        $stmt->execute([
            'clinic_id' => $serviceData['clinic_id'],
            'name' => $serviceData['name'],
            'price' => $serviceData['price'],
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update an existing service record.
     *
     * @param int $serviceId
     * @param array $serviceData
     * @return bool
     */
    public function update($serviceId, $serviceData)
    {
        $stmt = $this->db->prepare("
            UPDATE services 
            SET name = :name, price = :price
            WHERE id = :serviceId
        ");
        return $stmt->execute([
            'name' => $serviceData['name'],
            'price' => $serviceData['price'],
            'serviceId' => $serviceId,
        ]);
    }

    /**
     * Delete a service record by ID.
     *
     * @param int $serviceId
     * @return bool
     */
    public function delete($serviceId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM services WHERE id = :serviceId
        ");
        return $stmt->execute(['serviceId' => $serviceId]);
    }

    /**
     * Search for services by name within a clinic.
     *
     * @param int $clinicId
     * @param string $searchTerm
     * @return array
     */
    public function searchServices($clinicId, $searchTerm)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM services 
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
