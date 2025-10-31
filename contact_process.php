<!-- <?php 
session_start();
require 'config.php'; // Ton fichier de connexion PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

   if (empty($nom) || empty($email) || empty($message)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse e-mail invalide.";
        exit;
    }

$to = "nathan.mortier18@gmail.com";
$subject = "Nouveau message de contact de $nom $prenom";
$header = "From: $email\r\n";
$header .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$body = "Nom: $nom $ prénom\n";
$body .= "Email: $email\n";
$body .= "Message:\n$message\n";
if (mail($to, $subject, $body, $header)) {
    echo json_encode(["status" => "success", "message" => "Merci!, $nom. Votre message a bien été envoyé."]);
}else {
    echo json_encode(["status" => "error", "message" => "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer plus tard."]);
}
} else {
    echo "Méthode de requête invalide.";
}
?> -->