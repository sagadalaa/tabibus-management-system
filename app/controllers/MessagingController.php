<?php
/**
 * MessagingController for Clinic Management System
 * Author: Your Name
 * Description: Handles secure messaging between clinic admins and receptionists.
 */

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/MessagingModel.php';
require_once __DIR__ . '/../helpers/functions.php';

class MessagingController
{
    private $messagingModel;

    public function __construct()
    {
        $this->messagingModel = new MessagingModel();
    }

    /**
     * Display the messaging interface.
     */
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $userRole = $_SESSION['user_role'];

        // Get the list of conversations based on the user's role
        if ($userRole === 'clinic_admin') {
            $conversations = $this->messagingModel->getConversationsForAdmin($userId);
        } elseif ($userRole === 'receptionist') {
            $conversations = $this->messagingModel->getConversationsForReceptionist($userId);
        } else {
            $conversations = [];
        }

        // Fetch messages for the selected conversation
        $selectedUserId = $_GET['user'] ?? ($conversations[0]['user_id'] ?? null);
        $messages = $selectedUserId ? $this->messagingModel->getMessagesBetweenUsers($userId, $selectedUserId) : [];

        require __DIR__ . '/../../views/messages/index.php';
    }

    /**
     * Send a new message.
     */
    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                return;
            }

            $senderId = $_SESSION['user_id'];
            $receiverId = $_POST['receiver_id'];
            $message = trim($_POST['message']);

            // Validate inputs
            if (empty($receiverId) || empty($message)) {
                echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
                return;
            }

            // Save the message in the database
            $this->messagingModel->sendMessage($senderId, $receiverId, $message);

            echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
        }
    }

    /**
     * Fetch messages for a conversation.
     */
    public function fetchMessages()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $receiverId = $_GET['user'] ?? null;

        if (!$receiverId) {
            echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
            return;
        }

        $messages = $this->messagingModel->getMessagesBetweenUsers($userId, $receiverId);
        echo json_encode(['success' => true, 'messages' => $messages]);
    }
}
