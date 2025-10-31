<?php
session_start();
require 'config.php';

$room = $_GET['room'] ?? null;
if (!$room) { echo json_encode([]); exit; }

$stmt = $pdo->prepare("SELECT user_id, message FROM chat_messages WHERE room_id = ? ORDER BY created_at ASC");
$stmt->execute([$room]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
