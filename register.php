<?php
require 'config.php';
session_start();

// Si le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérifie si l'email existe déjà
    $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        $error = "⚠️ Cet email est déjà utilisé.";
    } else {
        // Ajoute le nouvel utilisateur
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $password]);

        // Connexion automatique après inscription
        $_SESSION['username'] = $username;

        // Redirection vers la page d'accueil
        header("Location: soutiens.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
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
    input {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
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
  </style>
</head>
<body>
  <div class="container">
    <h2>Créer un compte</h2>

    <?php if (!empty($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Mot de passe" required><br>
      <button type="submit">S'inscrire</button>
    </form>

    <p style="margin-top: 10px;">
      Déjà un compte ? <a href="login.php">Connecte-toi ici</a>
    </p>
  </div>
</body>
</html>
