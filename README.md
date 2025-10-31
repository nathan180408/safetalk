<?php
session_start();
require 'config.php';

// Récupère le pseudo de l'utilisateur connecté
$username = $_SESSION['username'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeTalk</title>
    <style>
        /* ======================== Styles principaux ======================== */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        nav {
            background-color: #619f2e;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 8vh;
        }

        nav h1 {
            color: white;
            font-size: 36px;
            font-weight: bold;
            margin: 0;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        .nav-links a:hover {
            text-decoration: dotted;
            color: yellow;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .avatar-bulle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            color: white;
            transition: transform 0.2s, background-color 0.2s;
        }

        .avatar-bulle:hover {
            transform: scale(1.2);
            background-color: #555;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 150px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            overflow: hidden;
            z-index: 100;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #3498db;
            color: white;
        }

        .accueil {
            color: white;
            text-align: center;
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);
            height: 92vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 25px;
            background-image: url('therapy-9567309_1280.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .accueil h2 {
            font-size: 48px;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px 25px;
            border-radius: 25px;
        }

        .accueil p {
            font-size: 24px;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 10px 20px;
            border-radius: 15px;
        }

        @media screen and (max-width:768px) {
            nav {
                flex-direction: column;
                height: auto;
                padding: 10px;
            }

            .nav-links {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }
        }

        #apropos {
            padding: 60px 20px;
            background-color: #b7e334ff;
            text-align: center;
            border-radius: 15px;
            margin: 40px auto;
            max-width: 1000px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        #apropos h2 {
            font-size: 36px;
            color: #3498db;
            margin-bottom: 20px;
            font-weight: bold;
        }

        #apropos p {
            font-size: 18px;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
        }

        #apropos p:hover {
            color: #2980b9;
            transition: 0.3s;
        }

        .contact {
            background-color: #f0f4f8;
            padding: 50px 20px;
            text-align: center;
            border-radius: 15px;
            margin: 40px auto;
            max-width: 800px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .contact h2 {
            color: #3498db;
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .contact p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #333;
        }

        .contact form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact input,
        .contact textarea {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .contact input:focus,
        .contact textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .contact button {
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .contact button:hover {
            background-color: #2980b9;
        }

        #form-message {
            font-weight: bold;
            margin-top: 10px;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }
        #aide {
    padding: 50px 20px;
    background-color: #dff0f7;
    text-align: center;
    border-radius: 15px;
    margin: 40px auto;
    max-width: 800px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

#aide h2 {
    color: #2c3e50;
    font-size: 36px;
    margin-bottom: 20px;
    font-weight: bold;
}

#aide p {
    font-size: 18px;
    margin-bottom: 30px;
    color: #34495e;
}

.aide-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.aide-item {
    background-color: white;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    text-align: left;
}

.aide-item h3 {
    margin: 0 0 5px 0;
    font-size: 20px;
    color: #3498db;
}

.aide-item p {
    margin: 0;
    font-size: 16px;
}

    </style>
</head>

<body>
    <nav>
        <h1>SafeTalk</h1>
        <div class="nav-links">
            <a href="#accueil">Accueil</a>
            <a href="forum.php">Forum</a>
            <a href="psychologue.php">Psychologue</a>
            <a href="#apropos">À propos</a>
            <a href="gestion_troubles.php">Aide & Troubles</a>
            <a href="#contact">Contact</a>

            <div class="dropdown">
                <div class="avatar-bulle" onclick="toggleMenu()" style="background-color: <?= $username ? '#3498db' : '#ccc' ?>;">
                    <?php if ($username): ?>
                        <?= strtoupper(substr($username, 0, 1)) ?>
                    <?php else: ?>
                        &#128100;
                    <?php endif; ?>
                </div>
                <div id="dropdown-menu" class="dropdown-menu">
                    <?php if ($username): ?>
                        <a href="change_password.php">Changer le mot de passe</a>
                        <a href="logout.php">Se déconnecter</a>
                    <?php else: ?>
                        <a href="login.php">Connexion</a>
                        <a href="register.php">S'inscrire</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <header>
        <section class="accueil" id="accueil">
            <h2>Bienvenue sur SafeTalk</h2>
            <p>Votre espace de soutien et d'écoute</p>
        </section>

        <section id="apropos" class="apropos">
            <h2>À propos de SafeTalk</h2>
            <p>SafeTalk est un espace sécurisé où chacun peut s’exprimer et trouver du soutien.
                Nous proposons des forums, des discussions thématiques et prochainement la possibilité
                de consulter des psychologues certifiés.</p>
        </section>
<section id="aide" class="aide">
    <h2>Besoin d'aide ?</h2>
    <p>Voici des ressources et numéros pour vous soutenir immédiatement :</p>
    
    <div class="aide-list">
        <div class="aide-item">
            <h3>Numéro national de prévention du suicide</h3>
            <p>Téléphone : <a href="tel:3114">3114</a> (24/7)</p>
        </div>
        <div class="aide-item">
            <h3>Violences et maltraitances</h3>
            <p>Téléphone : <a href="tel:3919">3919</a> (femmes victimes)</p>
        </div>
        <div class="aide-item">
            <h3>Enfants et adolescents en détresse</h3>
            <p>Téléphone : <a href="tel:0800 20 100">0800 20 100</a></p>
        </div>
        <div class="aide-item">
            <h3>Site web de ressources</h3>
            <p><a href="https://www.sos-suicide.be" target="_blank">https://www.sos-suicide.be</a></p>
        </div>
    </div>
</section>

        <section id="contact" class="contact">
            <h2>Contactez-nous</h2>
            <p>Vous avez des questions ou besoin de soutien ? Envoyez-nous un message.</p>
            <form id="contactForm" action="https://formspree.io/f/mrbokagq" method="POST">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Votre email" required>
                <label for="message">Votre message</label>
                <textarea name="message" id="message" placeholder="Votre message..." required></textarea>
                <button type="submit">Envoyer</button>
                <p id="form-message"></p>
            </form>
        </section>
    </header>

    <script>
        // ================= DROPDOWN =================
        function toggleMenu() {
            let menu = document.getElementById('dropdown-menu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }
        window.onclick = function(event) {
            if (!event.target.closest('.avatar-bulle')) {
                let menu = document.getElementById('dropdown-menu');
                if (menu) menu.style.display = 'none';
            }
        }

        // ================= Formspree =================
        const form = document.getElementById("contactForm");
        const message = document.getElementById("form-message");
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const data = new FormData(form);
            const response = await fetch(form.action, {
                method: form.method,
                body: data,
                headers: {
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                message.textContent = "✅ Message envoyé avec succès !";
                message.className = "success-message";
                form.reset();
            } else {
                message.textContent = "❌ Une erreur est survenue. Réessayez plus tard.";
                message.className = "error-message";
            }
        });
    </script>
</body>
</html>
