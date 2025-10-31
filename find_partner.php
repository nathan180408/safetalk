<?php
session_start();
require 'config.php';

$user = $_GET['user'] ?? null;
if (!$user) { echo json_encode(['room_id' => 0]); exit; }

// Vérifie si l'utilisateur est déjà dans une room
$stmt = $pdo->prepare("SELECT room_id FROM chat_rooms_users WHERE user_id = ?");
$stmt->execute([$user]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode(['room_id' => $row['room_id']]);
    exit;
}

// Cherche un partenaire libre
$stmt = $pdo->query("SELECT id FROM chat_rooms WHERE user2 IS NULL ORDER BY id ASC LIMIT 1");
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if ($room) {
    $roomId = $room['id'];
    $stmt = $pdo->prepare("UPDATE chat_rooms SET user2 = ? WHERE id = ?");
    $stmt->execute([$user, $roomId]);
} else {
    // Crée une nouvelle room
    $stmt = $pdo->prepare("INSERT INTO chat_rooms (user1) VALUES (?)");
    $stmt->execute([$user]);
    $roomId = $pdo->lastInsertId();
}

// Ajoute l'utilisateur dans la table room_users
$stmt = $pdo->prepare("INSERT INTO chat_rooms_users (room_id, user_id) VALUES (?, ?)");
$stmt->execute([$roomId, $user]);

echo json_encode(['room_id' => $roomId]);
