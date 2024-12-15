<?php
/**
 * Messages Template for Clinic Management System
 * Author: Your Name
 * Description: Displays a messaging interface for users.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'] ?? 'guest';
$userName = $_SESSION['user_name'] ?? 'Guest';

// Messages and conversations would be passed from the controller
$conversations = $conversations ?? [];
$messages = $messages ?? [];
$selectedUserId = $_GET['user'] ?? ($conversations[0]['user_id'] ?? null);
?>

<div class="messages-container">
    <!-- Sidebar: Conversations -->
    <div class="conversations-sidebar">
        <h3><?= t('Conversations') ?></h3>
        <ul class="conversations-list">
            <?php foreach ($conversations as $conversation): ?>
                <li class="<?= $selectedUserId == $conversation['user_id'] ? 'active' : '' ?>">
                    <a href="/messages?user=<?= $conversation['user_id'] ?>">
                        <div class="conversation-user">
                            <i class="icon icon-user"></i>
                            <span><?= htmlspecialchars($conversation['user_name']) ?></span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Main Chat Window -->
    <div class="chat-window">
        <?php if ($selectedUserId): ?>
            <div class="chat-header">
                <h3><?= htmlspecialchars($conversations[array_search($selectedUserId, array_column($conversations, 'user_id'))]['user_name'] ?? '') ?></h3>
            </div>
            <div class="chat-messages">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?= $message['sender_id'] == $userId ? 'sent' : 'received' ?>">
                        <p><?= htmlspecialchars($message['content']) ?></p>
                        <span class="timestamp"><?= htmlspecialchars($message['timestamp']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <form action="/messages/send" method="POST" class="chat-input">
                <input type="hidden" name="receiver_id" value="<?= $selectedUserId ?>">
                <textarea name="message" placeholder="<?= t('Type a message...') ?>" required></textarea>
                <button type="submit"><?= t('Send') ?></button>
            </form>
        <?php else: ?>
            <p><?= t('Select a conversation to start messaging.') ?></p>
        <?php endif; ?>
    </div>
</div>
