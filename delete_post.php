<?php
session_start();
require 'config.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = (int)$_POST['post_id'];
    $cat_id = (int)$_POST['cat_id'];
    $user_id = $_SESSION['user_id'];

    // Vérifie que le post appartient bien à l'utilisateur
    $stmt = $pdo->prepare("SELECT user_id FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post && $post['user_id'] == $user_id) {
        // Supprimer le post
        $delete = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $delete->execute([$post_id]);
    }
}

header("Location: forum.php?cat=$cat_id");
exit();
