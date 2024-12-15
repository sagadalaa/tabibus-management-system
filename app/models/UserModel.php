<?php
/**
 * UserModel for Clinic Management System
 * Author: Your Name
 * Description: Handles database interactions for user-related data.
 */

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Find a user by their username.
     *
     * @param string $username
     * @return array|null
     */
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    /**
     * Create a new user (admin, receptionist, etc.).
     *
     * @param array $userData
     * @return int The ID of the newly created user.
     */
    public function create($userData)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (full_name, clinic_name, phone, username, password, role, status, created_at)
            VALUES (:full_name, :clinic_name, :phone, :username, :password, :role, :status, NOW())
        ");
        $stmt->execute([
            'full_name' => $userData['full_name'],
            'clinic_name' => $userData['clinic_name'],
            'phone' => $userData['phone'],
            'username' => $userData['username'],
            'password' => $userData['password'],
            'role' => $userData['role'],
            'status' => $userData['status'],
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Get clinic information for a specific admin.
     *
     * @param int $clinicId
     * @return array|null
     */
    public function getClinicInfo($clinicId)
    {
        $stmt = $this->db->prepare("SELECT * FROM clinics WHERE admin_id = :clinicId");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetch();
    }

    /**
     * Update clinic information.
     *
     * @param int $clinicId
     * @param array $clinicData
     * @return bool
     */
    public function updateClinicInfo($clinicId, $clinicData)
    {
        $stmt = $this->db->prepare("
            UPDATE clinics 
            SET clinic_name = :clinic_name, address = :address, phone = :phone, social_links = :social_links
            WHERE admin_id = :clinicId
        ");
        return $stmt->execute([
            'clinic_name' => $clinicData['clinic_name'],
            'address' => $clinicData['address'],
            'phone' => $clinicData['phone'],
            'social_links' => $clinicData['social_links'],
            'clinicId' => $clinicId,
        ]);
    }

    /**
     * Get all receptionists for a specific clinic.
     *
     * @param int $clinicId
     * @return array
     */
    public function getReceptionistsByClinic($clinicId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'receptionist' AND clinic_id = :clinicId");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetchAll();
    }

    /**
     * Create a new receptionist.
     *
     * @param int $clinicId
     * @param string $username
     * @param string $password
     * @return int The ID of the newly created receptionist.
     */
    public function createReceptionist($clinicId, $username, $password)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (clinic_id, username, password, role, status, created_at)
            VALUES (:clinic_id, :username, :password, 'receptionist', 1, NOW())
        ");
        $stmt->execute([
            'clinic_id' => $clinicId,
            'username' => $username,
            'password' => $password,
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update receptionist information.
     *
     * @param int $receptionistId
     * @param string $username
     * @param string|null $password
     * @return bool
     */
    public function updateReceptionist($receptionistId, $username, $password = null)
    {
        $query = "UPDATE users SET username = :username";
        $params = ['username' => $username, 'id' => $receptionistId];

        if ($password) {
            $query .= ", password = :password";
            $params['password'] = $password;
        }

        $query .= " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Enable or disable a receptionist.
     *
     * @param int $receptionistId
     * @param int $status
     * @return bool
     */
    public function toggleReceptionistStatus($receptionistId, $status)
    {
        $stmt = $this->db->prepare("UPDATE users SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $receptionistId]);
    }

    /**
     * Delete a receptionist.
     *
     * @param int $receptionistId
     * @return bool
     */
    public function deleteReceptionist($receptionistId)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $receptionistId]);
    }

    /**
     * Update appointment limits for a clinic.
     *
     * @param int $clinicId
     * @param array $limits
     * @return bool
     */
    public function updateAppointmentLimits($clinicId, $limits)
    {
        $stmt = $this->db->prepare("
            UPDATE clinics 
            SET daily_limit = :daily_limit, weekly_limit = :weekly_limit, monthly_limit = :monthly_limit
            WHERE admin_id = :clinicId
        ");
        return $stmt->execute([
            'daily_limit' => $limits['daily'],
            'weekly_limit' => $limits['weekly'],
            'monthly_limit' => $limits['monthly'],
            'clinicId' => $clinicId,
        ]);
    }
}
