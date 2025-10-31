<?php
session_start();
require 'config.php';

$username = $_SESSION['username'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des troubles - SafeTalk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #619f2e;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        nav h1 {
            color: white;
            font-size: 28px;
            margin: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .trouble-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .trouble-card h2 {
            color: #3498db;
            margin-bottom: 10px;
        }

        .trouble-card p {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .trouble-card ul {
            margin-left: 20px;
        }

        .trouble-card ul li {
            margin-bottom: 5px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #619f2e;
            color: white;
            margin-top: 40px;
        }

        @media screen and (max-width:768px) {
            nav {
                flex-direction: column;
            }

            .nav-links {
                margin-top: 10px;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
        }
     button
        {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <nav>
        <h1>SafeTalk</h1>
        <div class="nav-links">
            <a href="soutiens.php">Accueil</a>
            <a href="forum.php">Forum</a>
            <a href="psychologue.php">Psychologue</a>
            <a href="gestion_troubles.php">Aide & Troubles</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <div class="container">
        <h1>Apprendre à gérer ses troubles</h1>
        <p>Découvrez des conseils et ressources pour mieux vivre avec différents troubles psychologiques.</p>

        <div class="trouble-card">
            <h2>Anxiété</h2>
            <p>Symptômes fréquents : palpitations, agitation, insomnie.</p>
            <ul>
                <li>Techniques de respiration et méditation.</li>
                <li>Marcher ou faire du sport léger.</li>
                <li>Numéro d’écoute : <a href="tel:3114">3114</a> (France – Suicide Écoute)</li>
            </ul>
        </div>

        <div class="trouble-card">
            <h2>Dépression</h2>
            <p>Symptômes fréquents : tristesse persistante, perte d’intérêt, fatigue.</p>
            <ul>
                <li>Parler à un proche ou tenir un journal.</li>
                <li>Consulter un psychologue ou psychiatre.</li>
                <li>Ressources : <a href="https://www.sos-depression.org/">SOS Dépression</a></li>
            </ul>
        </div>

        <div class="trouble-card">
            <h2>Stress</h2>
            <p>Symptômes fréquents : tension musculaire, irritabilité, maux de tête.</p>
            <ul>
                <li>Planifier sa journée et prendre des pauses.</li>
                <li>Relaxation guidée et cohérence cardiaque.</li>
            </ul>
        </div>

        <div class="trouble-card">
            <h2>Phobies</h2>
            <p>Symptômes fréquents : panique, anxiété intense, évitement.</p>
            <ul>
                <li>Exposition progressive à l’objet de la peur.</li>
                <li>Thérapie comportementale.</li>
            </ul>
        </div>

        <div class="trouble-card">
            <h2>Autres troubles</h2>
            <ul>
                <li>Consulter un professionnel de santé.</li>
                <li>Numéros d’urgence locaux.</li>
            </ul>
        </div>
    </div>

<section style="text-align:center; margin: 40px 0; background-color:#d4edda; padding:20px; border-radius:10px;">
    <a href="soutiens.php">
        <button>Retour à l'accueil</button>
    </a>
</section>


    <footer>
        SafeTalk - Soutien et aide psychologique
    </footer>
</body>

</html>