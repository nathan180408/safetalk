<?php
session_start();
require 'config.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];

    // Récupère le mot de passe actuel en base
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($current, $user['password'])) {
        // Met à jour le mot de passe
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        $update->execute([$hash, $username]);
        $success = "Mot de passe changé avec succès !";
    } else {
        $error = "Mot de passe actuel incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Changer le mot de passe</title>
<style>



    body {
      background: #f7f8fc;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    h2 {
      color: #333;
      margin-bottom: 20px;
    }
    input {
      width: 250px;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    button {
      background-color: #619f2e;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background-color: #4e7d24;
    }
</style>
</head>
<body>
<h2>Changer le mot de passe</h2>
<?php if($error) echo "<p style='color:red'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green'>$success</p>"; ?>

<form method="POST">
    <input type="password" name="current_password" placeholder="Mot de passe actuel" required><br><br>
    <input type="password" name="new_password" placeholder="Nouveau mot de passe" required><br><br>
    <button type="submit">Changer</button>
</form>

<p><a href="soutien.php">Retour</a></p>
</body>
</html>
