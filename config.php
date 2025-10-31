<?php
$host = "localhost";
$dbname = "safetalk";
$username = "root"; // identifiant par défaut sur WAMP
$password = "";     // mot de passe vide sur WAMP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
