<?php
session_start();
require_once('includes/config.php');

// Vérifier si l'utilisateur est connecté et a une réservation
if (!isset($_SESSION['user_id']) || !isset($_SESSION['last_reservation_id'])) {
    header('Location: reservation.php');
    exit();
}

// Récupérer les détails de la réservation
try {
    $stmt = $conn->prepare("SELECT v.*, r.date_visite, r.montant 
                           FROM visiteurs v 
                           JOIN reservations r ON v.reservation_id = r.id 
                           WHERE r.id = ? AND r.user_id = ?");
    $stmt->bind_param("ii", $_SESSION['last_reservation_id'], $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $visiteurs = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    die("Erreur lors de la récupération des informations");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation - Parc d'attractions</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/billeterie.css">
    <style>
        .confirmation-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .success-message {
            text-align: center;
            margin-bottom: 40px;
            color: #4CAF50;
        }

        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .ticket {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .ticket-header {
            border-bottom: 2px solid #4CAF50;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .print-button {
            text-align: center;
            margin-top: 30px;
        }

        .print-btn {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .email-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 30px auto;
            max-width: 500px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .email-form h3 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .email-btn {
            background: #4CAF50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .email-btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>

    <div class="confirmation-container">
        <div class="success-message">
            <h1>✓ Réservation confirmée !</h1>
            <p>Voici vos billets avec QR codes</p>
        </div>

        <div class="tickets-grid">
            <?php foreach ($visiteurs as $visiteur): 
                // Générer un QR code unique pour chaque visiteur
                $qr_data = [
                    'reservation_id' => $visiteur['reservation_id'],
                    'visitor_id' => $visiteur['id'],
                    'type' => $visiteur['type'],
                    'nom' => $visiteur['nom'],
                    'prenom' => $visiteur['prenom'],
                    'date' => $visiteur['date_visite']
                ];
                $qr_code = urlencode(json_encode($qr_data));
            ?>
                <div class="ticket">
                    <div class="ticket-header">
                        <h3><?php echo ucfirst($visiteur['type']); ?></h3>
                    </div>
                    <div class="ticket-info">
                        <p><strong>Nom :</strong> <?php echo htmlspecialchars($visiteur['nom']); ?></p>
                        <p><strong>Prénom :</strong> <?php echo htmlspecialchars($visiteur['prenom']); ?></p>
                        <p><strong>Date de visite :</strong> <?php echo date('d/m/Y', strtotime($visiteur['date_visite'])); ?></p>
                    </div>
                    <div class="qr-code">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $qr_code; ?>" 
                             alt="QR Code" 
                             title="Billet <?php echo htmlspecialchars($visiteur['nom']); ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="email-form">
            <h3>Recevoir les billets par email</h3>
            <form id="sendEmailForm" method="POST" action="send_tickets.php">
                <input type="hidden" name="reservation_id" value="<?php echo $_SESSION['last_reservation_id']; ?>">
                <div class="form-group">
                    <label for="email">Votre adresse email :</label>
                    <input type="email" id="email" name="email" required 
                           value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>"
                           placeholder="exemple@email.com">
                </div>
                <button type="submit" class="email-btn">Recevoir par email</button>
            </form>
        </div>

        <div class="print-button no-print">
            <button onclick="window.print()" class="print-btn">
                Imprimer tous les billets
            </button>
        </div>
    </div>
</body>
</html> 