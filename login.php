<?php
session_start();
require 'config.php'; // Ton fichier de connexion PDO

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "⚠️ Merci de remplir tous les champs.";
    } else {
        // Vérifie les informations de connexion
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Gestion "Rester connecté"
            if (isset($_POST['remember_me'])) {
                setcookie('user_id', $user['id'], time() + 30*24*60*60, "/"); // 30 jours
                setcookie('username', $user['username'], time() + 30*24*60*60, "/");
            }

            header("Location: soutiens.php");
            exit();
        } else {
            $error = "⚠️ Email ou mot de passe incorrect.";
        }
    }
}

// Si cookie existe mais session vide, on la recrée
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion SafeTalk</title>
  <style>
    body {
      background: #f7f8fc;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 350px;
      text-align: center;
    }
    h2 {
      color: #333;
      margin-bottom: 20px;
    }
    input[type="email"],
    input[type="password"] {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    label {
      display: block;
      margin: 10px 0;
      font-size: 14px;
    }
    button {
      background: #3498db;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover {
      background: #2980b9;
    }
    .error {
      color: red;
      margin-bottom: 10px;
    }
    .register-link {
      margin-top: 10px;
      display: block;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Se connecter</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mot de passe" required>
      <label>
        <input type="checkbox" name="remember_me"> Rester connecté
      </label>
      <button type="submit">Connexion</button>
    </form>

    <p class="register-link">
      Pas encore de compte ? <a href="register.php">Inscris-toi ici</a>
    </p>
  </div>
</body>
</html>
