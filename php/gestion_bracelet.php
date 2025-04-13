<?php
session_start();
require_once('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer les informations du bracelet
$sql = "SELECT b.*, r.date_debut, r.date_fin 
        FROM bracelets b 
        JOIN reservations r ON b.reservation_id = r.id 
        WHERE r.user_id = ? AND r.statut = 'confirmee'
        ORDER BY r.date_debut DESC LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$bracelet = $stmt->get_result()->fetch_assoc();

// Récupérer l'historique des transactions
if ($bracelet) {
    $sql = "SELECT * FROM transactions_bracelet 
            WHERE bracelet_id = ? 
            ORDER BY date_transaction DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bracelet['id']);
    $stmt->execute();
    $transactions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Traiter la recharge
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['montant_recharge'])) {
    $montant = $_POST['montant_recharge'];
    
    // Mettre à jour le solde
    $sql = "UPDATE bracelets SET solde = solde + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $montant, $bracelet['id']);
    
    if ($stmt->execute()) {
        // Enregistrer la transaction
        $sql = "INSERT INTO transactions_bracelet (bracelet_id, montant, type_transaction, description) 
                VALUES (?, ?, 'recharge', 'Recharge en ligne')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id", $bracelet['id'], $montant);
        $stmt->execute();
        
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion du Bracelet</title>
    <meta charset="utf-8">
    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .solde {
            font-size: 24px;
            color: #4CAF50;
            margin: 20px 0;
        }
        .transaction-list {
            margin-top: 20px;
        }
        .transaction-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .paiement {
            color: #f44336;
        }
        .recharge {
            color: #4CAF50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>
    
    <div class="container">
        <?php if ($bracelet): ?>
            <div class="card">
                <h2>Votre Bracelet Connecté</h2>
                <p>Code: <?php echo $bracelet['code_bracelet']; ?></p>
                <p>Valide du <?php echo $bracelet['date_debut']; ?> au <?php echo $bracelet['date_fin']; ?></p>
                <div class="solde">
                    Solde actuel: <?php echo number_format($bracelet['solde'], 2); ?>€
                </div>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Montant à recharger (€):</label>
                        <input type="number" name="montant_recharge" min="5" step="5" required>
                    </div>
                    <button type="submit" class="btn">Recharger</button>
                </form>
            </div>
            
            <div class="card">
                <h3>Historique des transactions</h3>
                <div class="transaction-list">
                    <?php foreach ($transactions as $transaction): ?>
                        <div class="transaction-item">
                            <span class="<?php echo $transaction['type_transaction']; ?>">
                                <?php echo $transaction['type_transaction'] === 'paiement' ? '-' : '+'; ?>
                                <?php echo number_format($transaction['montant'], 2); ?>€
                            </span>
                            <span><?php echo $transaction['description']; ?></span>
                            <small><?php echo $transaction['date_transaction']; ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <p>Aucun bracelet actif trouvé. Veuillez d'abord effectuer une réservation.</p>
                <a href="reservation.php" class="btn">Faire une réservation</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 