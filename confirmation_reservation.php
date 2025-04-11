<?php
session_start();
require_once('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer la dernière réservation
$sql = "SELECT r.*, p.* FROM reservations r 
        JOIN profils_visiteurs p ON r.user_id = p.user_id 
        WHERE r.user_id = ? 
        ORDER BY r.id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$reservation = $stmt->get_result()->fetch_assoc();

// Générer un code unique pour le bracelet
$bracelet_code = uniqid('BRAC_');

// Créer le bracelet dans la base de données
$sql = "INSERT INTO bracelets (reservation_id, code_bracelet, statut) VALUES (?, ?, 'assigne')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $reservation['id'], $bracelet_code);
$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de réservation</title>
    <meta charset="utf-8">
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .confirmation-details {
            margin: 20px 0;
            text-align: left;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        #qrcode {
            margin: 20px auto;
        }
        .print-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>
    
    <div class="container">
        <h1>Réservation confirmée !</h1>
        
        <div class="confirmation-details">
            <h2>Détails de votre réservation</h2>
            <p>Nom : <?php echo $reservation['nom']; ?></p>
            <p>Prénom : <?php echo $reservation['prenom']; ?></p>
            <p>Du : <?php echo $reservation['date_debut']; ?></p>
            <p>Au : <?php echo $reservation['date_fin']; ?></p>
            <p>Montant total : <?php echo $reservation['prix_total']; ?>€</p>
            <p>Code bracelet : <?php echo $bracelet_code; ?></p>
        </div>
        
        <div>
            <h3>Votre QR Code d'accès</h3>
            <div id="qrcode"></div>
            <p>Présentez ce QR code à l'entrée du parc pour récupérer votre bracelet connecté</p>
        </div>
        
        <button onclick="window.print()" class="print-btn">Imprimer la confirmation</button>
    </div>
    
    <script>
        // Générer le QR code
        var qr = qrcode(0, 'M');
        qr.addData('<?php echo $bracelet_code; ?>');
        qr.make();
        document.getElementById('qrcode').innerHTML = qr.createImgTag(6);
    </script>
</body>
</html> 