<?php
session_start();
require 'config.php';

$user = $_GET['user'] ?? null;
if (!$user) exit;

$stmt = $pdo->prepare("SELECT room_id FROM chat_rooms_users WHERE user_id = ?");
$stmt->execute([$user]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $roomId = $row['room_id'];
    // Supprime l'utilisateur de la room
    $stmt = $pdo->prepare("DELETE FROM chat_rooms_users WHERE user_id = ?");
    $stmt->execute([$user]);

    // Met à jour la room pour libérer le slot
    $stmt = $pdo->prepare("UPDATE chat_rooms SET user1 = NULL WHERE id = ? AND user1 = ?");
    $stmt->execute([$roomId, $user]);
    $stmt = $pdo->prepare("UPDATE chat_rooms SET user2 = NULL WHERE id = ? AND user2 = ?");
    $stmt->execute([$roomId, $user]);
}
