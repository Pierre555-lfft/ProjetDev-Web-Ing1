<?php
session_start();

// Vérifier si l'utilisateur est connecté et est un membre
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'membre' && $_SESSION['user'] !== 'complexe' && $_SESSION['user'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Objets Connectés</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/logo3.jpg">
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
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>
    
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
</body>
</html> 