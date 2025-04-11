<?php
session_start();
require_once('includes/config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer les réservations actives de l'utilisateur
$reservations = null;
try {
    $stmt = $conn->prepare("
        SELECT r.*, v.* 
        FROM reservations r 
        LEFT JOIN visiteurs v ON r.id = v.reservation_id 
        WHERE r.user_id = ? 
        AND r.date_visite >= CURDATE() 
        AND r.statut = 'payee'
        ORDER BY r.date_visite ASC
    ");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservations = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $error = "Erreur lors de la récupération des réservations";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Objets Connectés - Parc d'attractions</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/objets_connectes.css">
    <style>
        .connected-objects-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .reservation-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .reservation-header {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .visitors-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .visitor-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }

        .no-reservation {
            text-align: center;
            padding: 50px;
            background: #f8f9fa;
            border-radius: 15px;
            margin-top: 30px;
        }

        .no-reservation h2 {
            color: #666;
            margin-bottom: 20px;
        }

        .no-reservation p {
            color: #888;
        }

        .object-controls {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .control-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .control-btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>

    <div class="connected-objects-container">
        <h1>Gestion des Objets Connectés</h1>

        <?php if (empty($reservations)): ?>
            <div class="no-reservation">
                <h2>Aucune réservation trouvée</h2>
                <p>Vous devez d'abord effectuer une réservation pour accéder aux fonctionnalités des objets connectés.</p>
            </div>
        <?php else: ?>
            <?php 
            // Grouper les visiteurs par réservation
            $grouped_reservations = [];
            foreach ($reservations as $row) {
                if (!isset($grouped_reservations[$row['reservation_id']])) {
                    $grouped_reservations[$row['reservation_id']] = [
                        'date_visite' => $row['date_visite'],
                        'montant' => $row['montant'],
                        'visitors' => []
                    ];
                }
                if ($row['nom']) { // Si le visiteur existe
                    $grouped_reservations[$row['reservation_id']]['visitors'][] = $row;
                }
            }
            ?>

            <?php foreach ($grouped_reservations as $reservation_id => $reservation): ?>
                <div class="reservation-card">
                    <div class="reservation-header">
                        <h2>Réservation pour le <?php echo date('d/m/Y', strtotime($reservation['date_visite'])); ?></h2>
                    </div>

                    <div class="visitors-list">
                        <?php foreach ($reservation['visitors'] as $visitor): ?>
                            <div class="visitor-card">
                                <h3><?php echo htmlspecialchars($visitor['prenom'] . ' ' . $visitor['nom']); ?></h3>
                                <p>Type : <?php echo ucfirst($visitor['type']); ?></p>
                                <div class="object-controls">
                                    <button class="control-btn" onclick="toggleBracelet(<?php echo $visitor['id']; ?>)">
                                        Activer/Désactiver Bracelet
                                    </button>
                                    <button class="control-btn" onclick="locateVisitor(<?php echo $visitor['id']; ?>)">
                                        Localiser
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
    function toggleBracelet(visitorId) {
        // Simulation de l'activation/désactivation du bracelet
        alert('Bracelet ' + visitorId + ' activé/désactivé');
    }

    function locateVisitor(visitorId) {
        // Simulation de la localisation
        alert('Localisation du visiteur ' + visitorId + ' en cours...');
    }
    </script>
</body>
</html> 