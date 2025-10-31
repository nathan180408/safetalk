<?php
session_start();
require 'config.php';

$room = $_POST['room'] ?? null;
$user = $_POST['user'] ?? null;
$msg = $_POST['msg'] ?? null;

if ($room && $user && $msg) {
    $stmt = $pdo->prepare("INSERT INTO chat_messages (room_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$room, $user, $msg]);
}
