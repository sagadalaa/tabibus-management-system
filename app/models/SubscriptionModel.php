<?php
/**
 * SubscriptionModel for Clinic Management System
 * Author: Your Name
 * Description: Handles database interactions for subscription-related data.
 */

class SubscriptionModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get the active subscription for a specific clinic.
     *
     * @param int $clinicId
     * @return array|null
     */
    public function getActiveSubscription($clinicId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM subscriptions
            WHERE clinic_id = :clinicId AND status = 'active'
            LIMIT 1
        ");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetch();
    }

    /**
     * Get all subscriptions for a specific clinic.
     *
     * @param int $clinicId
     * @return array
     */
    public function getSubscriptionsByClinic($clinicId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM subscriptions
            WHERE clinic_id = :clinicId
            ORDER BY start_date DESC
        ");
        $stmt->execute(['clinicId' => $clinicId]);
        return $stmt->fetchAll();
    }

    /**
     * Create a new subscription record.
     *
     * @param array $subscriptionData
     * @return int The ID of the newly created subscription.
     */
    public function create($subscriptionData)
    {
        $stmt = $this->db->prepare("
            INSERT INTO subscriptions (clinic_id, type, price, start_date, end_date, status, created_at)
            VALUES (:clinic_id, :type, :price, :start_date, :end_date, :status, NOW())
        ");
        $stmt->execute([
            'clinic_id' => $subscriptionData['clinic_id'],
            'type' => $subscriptionData['type'],
            'price' => $subscriptionData['price'],
            'start_date' => $subscriptionData['start_date'],
            'end_date' => $subscriptionData['end_date'],
            'status' => $subscriptionData['status'],
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update the status of a subscription.
     *
     * @param int $subscriptionId
     * @param string $status
     * @return bool
     */
    public function updateStatus($subscriptionId, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE subscriptions 
            SET status = :status 
            WHERE id = :subscriptionId
        ");
        return $stmt->execute([
            'status' => $status,
            'subscriptionId' => $subscriptionId,
        ]);
    }

    /**
     * Check if a clinic has an active subscription.
     *
     * @param int $clinicId
     * @return bool
     */
    public function hasActiveSubscription($clinicId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM subscriptions
            WHERE clinic_id = :clinicId AND status = 'active'
        ");
        $stmt->execute(['clinicId' => $clinicId]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    /**
     * Calculate the remaining days for an active subscription.
     *
     * @param int $subscriptionId
     * @return int
     */
    public function getRemainingDays($subscriptionId)
    {
        $stmt = $this->db->prepare("
            SELECT DATEDIFF(end_date, NOW()) AS remaining_days
            FROM subscriptions
            WHERE id = :subscriptionId AND status = 'active'
        ");
        $stmt->execute(['subscriptionId' => $subscriptionId]);
        $result = $stmt->fetch();
        return $result['remaining_days'] ?? 0;
    }

    /**
     * Renew a subscription by extending its end date.
     *
     * @param int $subscriptionId
     * @param string $newEndDate
     * @return bool
     */
    public function renewSubscription($subscriptionId, $newEndDate)
    {
        $stmt = $this->db->prepare("
            UPDATE subscriptions 
            SET end_date = :newEndDate
            WHERE id = :subscriptionId
        ");
        return $stmt->execute([
            'newEndDate' => $newEndDate,
            'subscriptionId' => $subscriptionId,
        ]);
    }
}
