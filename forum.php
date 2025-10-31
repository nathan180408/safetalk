<?php
require 'config.php';
session_start();

// Récupérer catégories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

// Catégorie sélectionnée
$category_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;

// Nouveau post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_post']) && isset($_SESSION['username'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("INSERT INTO posts (category_id, user_id, title, content) VALUES (?, ?, ?, ?)");
        $stmt->execute([$category_id, $user_id, $title, $content]);
        header("Location: forum.php?cat=$category_id");
        exit();
    }

    if (isset($_POST['delete_post'])) {
        $post_id = $_POST['post_id'];
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        header("Location: forum.php?cat=$category_id");
        exit();
    }

    if (isset($_POST['submit_reply']) && isset($_SESSION['username'])) {
        $reply_content = $_POST['reply_content'];
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("INSERT INTO replies (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$post_id, $user_id, $reply_content]);
        header("Location: forum.php?cat=$category_id");
        exit();
    }
}

// Récupérer posts
$posts = [];
if ($category_id) {
    $stmt = $pdo->prepare("
        SELECT posts.*, users.username, users.avatar
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE category_id = ? 
        ORDER BY created_at DESC
    ");
    $stmt->execute([$category_id]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Forum SafeTalk</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f4f4;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 220px;
            background: #3498db;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #2980b9;
        }

        .home-btn {
            background: #2ecc71;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .home-btn:hover {
            background: #27ae60;
        }

        .main {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .topnav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #2980b9;
            color: white;
        }

        .topnav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .topnav a:hover {
            text-decoration: underline;
        }

        .new-post {
            margin-bottom: 30px;
        }

        .new-post input,
        .new-post textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .new-post button {
            background: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .new-post button:hover {
            background: #2980b9;
        }

        .post {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 15px;
            flex-direction: column;
        }

        .post-header {
            display: flex;
            gap: 15px;
        }

        .post-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .post-content h3 {
            margin: 0;
        }

        .post-content p {
            margin: 5px 0;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.2s;
        }

        .delete-btn:hover {
            background: #c0392b;
        }

        .login-msg {
            font-weight: bold;
            color: #e74c3c;
        }

        .reply-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
            margin-bottom: 5px;
            font-family: Arial, sans-serif;
        }

        .reply-form button {
            background: #8e44ad;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .reply-form button:hover {
            background: #732d91;
        }

        .reply-form {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .reply {
            padding-left: 20px;
            border-left: 2px solid #ccc;
            margin-top: 10px;
        }

        .show-replies-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        .show-replies-btn:hover {
            background: #2980b9;
        }
    </style>
    <script>
        function toggleReplies(postId) {
            const repliesDiv = document.getElementById('replies-' + postId);
            if (repliesDiv.style.display === 'none') {
                repliesDiv.style.display = 'block';
            } else {
                repliesDiv.style.display = 'none';
            }
        }
    </script>
</head>

<body>

    <div class="sidebar">
        <h2>Catégories</h2>
        <a href="forum.php">Accueil</a>
        <?php foreach ($categories as $cat): ?>
            <a href="forum.php?cat=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></a>
        <?php endforeach; ?>
        <a href="soutiens.php" class="home-btn">🏠 Retour à l'accueil</a>
    </div>

    <div class="main">
        <div class="topnav">
            <?php if (isset($_SESSION['username'])): ?>
                Salut <?= htmlspecialchars($_SESSION['username']) ?> |
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="register.php">S'inscrire</a> | <a href="login.php">Se connecter</a>
            <?php endif; ?>
        </div>

        <h1>Forum SafeTalk</h1>

        <?php if ($category_id): ?>
            <h2>Posts dans <?= htmlspecialchars($categories[array_search($category_id, array_column($categories, 'id'))]['name']) ?></h2>

            <?php if (isset($_SESSION['username'])): ?>
                <div class="new-post">
                    <h3>Créer un nouveau post</h3>
                    <form method="POST">
                        <input type="text" name="title" placeholder="Titre" required>
                        <textarea name="content" placeholder="Votre message" rows="5" required></textarea>
                        <button type="submit" name="submit_post">Poster</button>
                    </form>
                </div>
            <?php else: ?>
                <p class="login-msg">Connectez-vous pour envoyer un message.</p>
            <?php endif; ?>

            <?php if (count($posts) === 0): ?>
                <p>Aucun message disponible pour le moment.</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="post-header">
                            <img src="<?= htmlspecialchars($post['avatar'] ?? 'avatars/default.png') ?>" alt="Avatar">
                            <div class="post-content">
                                <h3><?= htmlspecialchars($post['title']) ?></h3>
                                <p>par <strong><?= htmlspecialchars($post['username']) ?></strong> le <?= $post['created_at'] ?></p>
                                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                                <button class="show-replies-btn" onclick="toggleReplies(<?= $post['id'] ?>)">Voir les réponses</button>
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                                    <form method="POST" style="margin-top:10px;">
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <button type="submit" name="delete_post" class="delete-btn">🗑️ Supprimer</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="reply-form" id="replies-<?= $post['id'] ?>" style="display:none;">
                            <?php if (isset($_SESSION['username'])): ?>
                                <form method="POST">
                                    <textarea name="reply_content" placeholder="Votre réponse..." rows="3" required></textarea>
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <button type="submit" name="submit_reply">Envoyer</button>
                                </form>
                            <?php else: ?>
                                <p class="login-msg">Connectez-vous pour répondre.</p>
                            <?php endif; ?>
                            <?php
                            $stmt = $pdo->prepare("SELECT replies.*, users.username, users.avatar FROM replies JOIN users ON replies.user_id=users.id WHERE post_id=? ORDER BY created_at ASC");
                            $stmt->execute([$post['id']]);
                            $post_replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($post_replies as $reply):
                            ?>
                                <div class="reply">
                                    <p><strong><?= htmlspecialchars($reply['username']) ?></strong> le <?= $reply['created_at'] ?></p>
                                    <p><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php else: ?>
            <p>Sélectionnez une catégorie pour voir les messages.</p>
        <?php endif; ?>
    </div>
</body>

</html>