<?php

include('hautPage.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Objets Connectés</title>
    <meta charset="utf-8">
    <link rel="icon" href="../images/logo3.jpg">
    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .bracelet-info {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
            background-color: #4CAF50;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .objects-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .objects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .object-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .object-card:hover {
            transform: translateY(-5px);
        }

        .object-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .object-info {
            padding: 20px;
        }

        .object-title {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #333;
        }

        .object-description {
            color: #666;
            margin-bottom: 15px;
        }

        .view-button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .view-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestion des Objets Connectés</h2>
        
        <div class="bracelet-info">
            <h3>Votre Bracelet Connecté</h3>
            <p>Statut : <span class="status">Actif</span></p>
            <p>Numéro de série : #12345</p>
            <p>Solde disponible : 50€</p>
            <p>Dernière utilisation : 15/03/2024 14:30</p>
        </div>

        <div class="actions">
            <h3>Actions disponibles</h3>
            <a href="recharger_bracelet.php" class="btn">Recharger le bracelet</a>
            <a href="historique_bracelet.php" class="btn">Voir l'historique</a>
            <a href="localiser_bracelet.php" class="btn">Localiser le bracelet</a>
        </div>
    </div>

    <div class="objects-container">
        <h1>Objets Connectés du Parc</h1>
        
        <div class="objects-grid">
            <div class="object-card" onclick="window.location.href='grand_huit.php'">
                <img src="images/grand_huit.jpg" alt="Grand Huit" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Grand Huit - Le Dragon</h2>
                    <p class="object-description">Suivez en temps réel le statut et le temps d'attente de notre attraction phare !</p>
                    <a href="grand_huit.php" class="view-button">Voir les détails</a>
                </div>
            </div>
            
            <div class="object-card" onclick="window.location.href='carrousel.php'">
                <img src="images/carrousel.jpg" alt="Carrousel" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Carrousel Enchanté</h2>
                    <p class="object-description">Un manège féerique pour petits et grands !</p>
                    <a href="carrousel.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='chute_libre.php'">
                <img src="images/chute_libre.jpg" alt="Chute Libre" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Chute Libre - L'Extrême</h2>
                    <p class="object-description">Sensations fortes garanties avec cette chute vertigineuse !</p>
                    <a href="chute_libre.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='vestiaire.php'">
                <img src="images/vestiaire.jpg" alt="Vestiaire" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Vestiaire Connecté</h2>
                    <p class="object-description">Gérez votre casier et accédez à vos affaires en toute sécurité.</p>
                    <a href="vestiaire.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='stand_photo.php'">
                <img src="images/stand_photo.jpg" alt="Stand Photo" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Stand Photo - La Statue Magique</h2>
                    <p class="object-description">Capturez vos souvenirs avec notre statue magique !</p>
                    <a href="stand_photo.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='portique_entree.php'">
                <img src="images/portique_entree.jpg" alt="Portique Entrée" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Portique d'Entrée</h2>
                    <p class="object-description">Suivez l'état du portique d'entrée en temps réel.</p>
                    <a href="portique_entree.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='portique_sortie.php'">
                <img src="images/portique_sortie.jpg" alt="Portique Sortie" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Portique de Sortie</h2>
                    <p class="object-description">Consultez l'état du portique de sortie en temps réel.</p>
                    <a href="portique_sortie.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='panneau_affichage.php'">
                <img src="images/panneau_affichage.jpg" alt="Panneau d'Affichage" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Panneau d'Affichage</h2>
                    <p class="object-description">Consultez les informations affichées sur nos panneaux en temps réel.</p>
                    <a href="panneau_affichage.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='aspirateur_connecte.php'">
                <img src="images/aspirateur.jpg" alt="Aspirateur Connecté" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Aspirateur Connecté</h2>
                    <p class="object-description">Suivez le nettoyage automatique du parc.</p>
                    <a href="aspirateur_connecte.php" class="view-button">Voir les détails</a>
                </div>
            </div>

            <div class="object-card" onclick="window.location.href='chateau_gonflable.php'">
                <img src="images/chateau_gonflable.jpg" alt="Château Gonflable" class="object-image">
                <div class="object-info">
                    <h2 class="object-title">Château Gonflable</h2>
                    <p class="object-description">Vérifiez l'état du château gonflable.</p>
                    <a href="chateau_gonflable.php" class="view-button">Voir les détails</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 