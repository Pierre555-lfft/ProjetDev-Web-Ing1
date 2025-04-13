<?php
session_start();
require_once('includes/config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['etape']) && $_POST['etape'] === 'infos') {
        // Sauvegarder les informations des visiteurs en session
        $_SESSION['visitors'] = [
            'adult' => $_POST['adult'] ?? [],
            'child' => $_POST['child'] ?? [],
            'senior' => $_POST['senior'] ?? []
        ];
        
        // Rediriger vers l'étape de paiement
        header("Location: reservation.php?etape=paiement");
        exit();
    }
    
    if (isset($_POST['etape']) && $_POST['etape'] === 'paiement') {
        try {
            // Générer un QR code unique pour la réservation
            $reservation_qr = uniqid('RES_', true);
            
            // Insérer la réservation
            $stmt = $conn->prepare("INSERT INTO reservations (user_id, date_visite, montant, qr_code, statut) VALUES (?, ?, ?, ?, 'payee')");
            $montant = str_replace(['€', ' '], '', $_SESSION['total']);
            $montant = floatval($montant);
            
            $stmt->bind_param("isds", 
                $_SESSION['user_id'], 
                $_SESSION['selected_date'],
                $montant,
                $reservation_qr
            );
            
            if ($stmt->execute()) {
                $reservation_id = $conn->insert_id;
                $_SESSION['last_reservation_id'] = $reservation_id;

                // Insérer les visiteurs
                $visitor_stmt = $conn->prepare("INSERT INTO visiteurs (reservation_id, type, nom, prenom, age, taille, date_visite, qr_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                foreach ($_SESSION['visitors'] as $type => $visitors) {
                    foreach ($visitors as $visitor) {
                        // Générer un QR code unique pour chaque visiteur
                        $visitor_qr = uniqid('VIS_', true);
                        
                        $visitor_stmt->bind_param("isssisss", 
                            $reservation_id,
                            $type,
                            $visitor['nom'],
                            $visitor['prenom'],
                            $visitor['age'],
                            $visitor['taille'],
                            $_SESSION['selected_date'],
                            $visitor_qr
                        );
                        $visitor_stmt->execute();
                    }
                }

                // Redirection vers la page de confirmation
                header("Location: confirmation.php");
                exit();
            }
        } catch (Exception $e) {
            $error = "Erreur lors de l'enregistrement : " . $e->getMessage();
            echo $error; // Pour le débogage
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Réservation - Parc d'attractions</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/billeterie.css">
    <style>
        .reservation-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
        }

        .step {
            text-align: center;
            flex: 1;
            position: relative;
        }

        .step.active {
            color: #4CAF50;
            font-weight: bold;
        }

        .calendar-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 20px;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .calendar-day {
            min-height: 80px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .calendar-day:not(.empty):hover {
            background-color: #f0f0f0;
            transform: scale(1.05);
        }

        .calendar-day.selected {
            background-color: #4CAF50;
            color: white;
        }

        .calendar-day.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px auto;
            max-width: 600px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        .btn {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }

        .btn:hover {
            background: #45a049;
        }

        .payment-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px auto;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .credit-card {
            background: linear-gradient(45deg, #0a0a0a, #3a4452);
            border-radius: 15px;
            padding: 20px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            height: 200px;
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            top: 0;
            left: 0;
            padding: 20px;
            background: linear-gradient(45deg, #0a0a0a, #3a4452);
            border-radius: 15px;
        }

        .card-front {
            transform: rotateY(0deg);
        }

        .card-back {
            transform: rotateY(180deg);
        }

        .chip {
            background: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin: 20px auto;
        }

        .magnetic-strip {
            background: black;
            height: 40px;
            margin: 20px 0;
        }

        .cvv-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .cvv {
            background: white;
            border-radius: 5px;
            width: 40px;
            height: 20px;
            text-align: center;
        }

        .card-holder, .card-expiry {
            display: flex;
            justify-content: space-between;
        }

        .label {
            font-weight: bold;
        }

        .price-summary {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #666;
        }

        .price-total {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            font-weight: bold;
            font-size: 1.2em;
        }

        .ticket-selection {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .ticket-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .ticket-type {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .quantity-selector {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: none;
            background: #4CAF50;
            color: white;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }

        .total-price {
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .month-nav {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .month-nav:hover {
            background: #45a049;
        }

        .price-indicator {
            font-size: 12px;
            margin-top: 5px;
        }

        .peak-price {
            color: #e74c3c;
        }

        .off-peak-price {
            color: #27ae60;
        }

        .day-price {
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
        }

        .peak-price {
            color: #e74c3c;
        }

        .off-peak-price {
            color: #27ae60;
        }

        .continue-button-container {
            text-align: center;
            margin-top: 30px;
        }

        .continue-btn {
            padding: 15px 40px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .continue-btn:hover:not(.disabled) {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        .continue-btn.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .empty {
            background: transparent;
            border: none;
        }

        .month-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
        }

        .calendar-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            text-align: center;
            font-weight: bold;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .month-nav {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .month-nav:hover {
            background: #45a049;
        }

        .visitor-section {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .visitor-section h3 {
            margin-bottom: 20px;
            color: #4CAF50;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }

        .total-and-continue {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .total-price {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .total-price h3 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        #total-amount {
            color: #4CAF50;
            font-weight: bold;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
        }

        .error {
            border-color: red !important;
        }

        .form-group input.error {
            background-color: #fff0f0;
        }

        .price-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .date-info {
            color: #666;
            font-style: italic;
        }

        .tarif-info {
            color: #4CAF50;
            font-weight: bold;
        }

        .price-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #4CAF50;
            font-size: 1.2em;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>

    <div class="reservation-steps">
        <div class="step <?php echo (!isset($_GET['etape']) || $_GET['etape'] === 'date') ? 'active' : ''; ?>">1. Choisir une date</div>
        <div class="step <?php echo (isset($_GET['etape']) && $_GET['etape'] === 'infos') ? 'active' : ''; ?>">2. Informations personnelles</div>
        <div class="step <?php echo (isset($_GET['etape']) && $_GET['etape'] === 'paiement') ? 'active' : ''; ?>">3. Paiement</div>
    </div>

    <div class="reservation-container">
        <?php if (!isset($_GET['etape']) || $_GET['etape'] === 'date'): ?>
            <!-- 1. Section sélection des billets -->
            <div class="ticket-selection">
                <h2>Sélectionnez vos billets</h2>
                <div class="ticket-types">
                    <div class="ticket-type">
                        <h3>Adulte (12+ ans)</h3>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn minus" data-type="adult">-</button>
                            <input type="number" name="adult_tickets" value="0" min="0" max="10" class="quantity-input" data-price="35">
                            <button type="button" class="quantity-btn plus" data-type="adult">+</button>
                        </div>
                    </div>
                    
                    <div class="ticket-type">
                        <h3>Enfant (3-11 ans)</h3>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn minus" data-type="child">-</button>
                            <input type="number" name="child_tickets" value="0" min="0" max="10" class="quantity-input" data-price="28">
                            <button type="button" class="quantity-btn plus" data-type="child">+</button>
                        </div>
                    </div>
                    
                    <div class="ticket-type">
                        <h3>Senior (60+ ans)</h3>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn minus" data-type="senior">-</button>
                            <input type="number" name="senior_tickets" value="0" min="0" max="10" class="quantity-input" data-price="32">
                            <button type="button" class="quantity-btn plus" data-type="senior">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Section navigation des mois et calendrier -->
            <div class="calendar-section">
                <div class="month-navigation">
                    <button id="prevMonth" class="month-nav">&lt; Mois précédent</button>
                    <h2 id="currentMonth">Décembre 2023</h2>
                    <button id="nextMonth" class="month-nav">Mois suivant &gt;</button>
                </div>
                <div class="calendar-grid">
                    <div class="calendar-header">
                        <div>Lun</div><div>Mar</div><div>Mer</div><div>Jeu</div>
                        <div>Ven</div><div>Sam</div><div>Dim</div>
                    </div>
                    <div id="calendar" class="calendar">
                        <!-- Le calendrier sera généré en JavaScript -->
                    </div>
                </div>
            </div>

            <!-- 3. Section total et bouton continuer -->
            <div class="total-and-continue">
                <div class="total-price">
                    <h3>Total : <span id="total-amount">0€</span></h3>
                </div>
                <div class="continue-button-container">
                    <button id="continueBtn" class="btn continue-btn disabled" disabled onclick="window.location.href='reservation.php?etape=infos'">
                        Continuer
                    </button>
                </div>
            </div>
        <?php elseif ($_GET['etape'] === 'infos'): ?>
            <div class="form-container">
                <h2>Informations des visiteurs</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="visitorsForm">
                    <input type="hidden" name="etape" value="infos">
                    
                    <?php
                    // Récupérer les quantités depuis la session
                    $adult_count = $_SESSION['tickets']['adult'] ?? 0;
                    $child_count = $_SESSION['tickets']['child'] ?? 0;
                    $senior_count = $_SESSION['tickets']['senior'] ?? 0;
                    
                    // Générer les formulaires pour les adultes
                    for ($i = 1; $i <= $adult_count; $i++): ?>
                        <div class="visitor-section">
                            <h3>Adulte <?php echo $adult_count > 1 ? $i : ''; ?></h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nom:</label>
                                    <input type="text" name="adult[<?php echo $i; ?>][nom]" required>
                                </div>
                                <div class="form-group">
                                    <label>Prénom:</label>
                                    <input type="text" name="adult[<?php echo $i; ?>][prenom]" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Âge:</label>
                                    <input type="number" name="adult[<?php echo $i; ?>][age]" required min="12" max="59">
                                </div>
                                <div class="form-group">
                                    <label>Taille (cm):</label>
                                    <input type="number" name="adult[<?php echo $i; ?>][taille]" required min="50" max="250">
                                </div>
                            </div>
                        </div>
                    <?php endfor;

                    // Générer les formulaires pour les enfants
                    for ($i = 1; $i <= $child_count; $i++): ?>
                        <div class="visitor-section">
                            <h3>Enfant <?php echo $child_count > 1 ? $i : ''; ?></h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nom:</label>
                                    <input type="text" name="child[<?php echo $i; ?>][nom]" required>
                                </div>
                                <div class="form-group">
                                    <label>Prénom:</label>
                                    <input type="text" name="child[<?php echo $i; ?>][prenom]" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Âge:</label>
                                    <input type="number" name="child[<?php echo $i; ?>][age]" required min="3" max="11">
                                </div>
                                <div class="form-group">
                                    <label>Taille (cm):</label>
                                    <input type="number" name="child[<?php echo $i; ?>][taille]" required min="50" max="250">
                                </div>
                            </div>
                        </div>
                    <?php endfor;

                    // Générer les formulaires pour les seniors
                    for ($i = 1; $i <= $senior_count; $i++): ?>
                        <div class="visitor-section">
                            <h3>Senior <?php echo $senior_count > 1 ? $i : ''; ?></h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nom:</label>
                                    <input type="text" name="senior[<?php echo $i; ?>][nom]" required>
                                </div>
                                <div class="form-group">
                                    <label>Prénom:</label>
                                    <input type="text" name="senior[<?php echo $i; ?>][prenom]" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Âge:</label>
                                    <input type="number" name="senior[<?php echo $i; ?>][age]" required min="60" max="120">
                                </div>
                                <div class="form-group">
                                    <label>Taille (cm):</label>
                                    <input type="number" name="senior[<?php echo $i; ?>][taille]" required min="50" max="250">
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                    
                    <button type="submit" class="btn">Continuer vers le paiement</button>
                </form>
            </div>

        <?php elseif ($_GET['etape'] === 'paiement'): ?>
            <div class="payment-container">
                <h2>Paiement</h2>
                
                <div class="credit-card" id="creditCard">
                    <div class="card-front">
                        <div class="chip"></div>
                        <div class="card-number" id="cardNumberDisplay">**** **** **** ****</div>
                        <div class="card-info">
                            <div class="card-holder">
                                <div class="label">Titulaire</div>
                                <div id="cardHolderDisplay">VOTRE NOM</div>
                            </div>
                            <div class="card-expiry">
                                <div class="label">Expire</div>
                                <div id="expiryDisplay">MM/YY</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <div class="magnetic-strip"></div>
                        <div class="cvv-container">
                            <div class="cvv" id="cvvDisplay">***</div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="" id="paymentForm">
                    <input type="hidden" name="etape" value="paiement">
                    <input type="hidden" name="montant" value="<?php echo $_SESSION['total']; ?>">
                    
                    <div class="form-group">
                        <label>Numéro de carte:</label>
                        <input type="text" name="card_number" id="cardNumber" required 
                               placeholder="1234 5678 9012 3456" 
                               maxlength="16">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date d'expiration:</label>
                            <input type="text" name="expiry" id="expiry" required 
                                   placeholder="MM/YY" 
                                   maxlength="5">
                        </div>
                        
                        <div class="form-group">
                            <label>CVV:</label>
                            <input type="text" name="cvv" id="cvv" required 
                                   placeholder="123" 
                                   maxlength="3">
                        </div>
                    </div>
                    
                    <div class="price-summary">
                        <?php 
                        // Récapitulatif des billets
                        if (isset($_SESSION['tickets']['adult']) && $_SESSION['tickets']['adult'] > 0): ?>
                            <div class="price-item">
                                <span><?php echo $_SESSION['tickets']['adult']; ?> billet<?php echo $_SESSION['tickets']['adult'] > 1 ? 's' : ''; ?> Adulte</span>
                                <span><?php echo number_format($_SESSION['tickets']['adult'] * 35, 2); ?> €</span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['tickets']['child']) && $_SESSION['tickets']['child'] > 0): ?>
                            <div class="price-item">
                                <span><?php echo $_SESSION['tickets']['child']; ?> billet<?php echo $_SESSION['tickets']['child'] > 1 ? 's' : ''; ?> Enfant</span>
                                <span><?php echo number_format($_SESSION['tickets']['child'] * 28, 2); ?> €</span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['tickets']['senior']) && $_SESSION['tickets']['senior'] > 0): ?>
                            <div class="price-item">
                                <span><?php echo $_SESSION['tickets']['senior']; ?> billet<?php echo $_SESSION['tickets']['senior'] > 1 ? 's' : ''; ?> Senior</span>
                                <span><?php echo number_format($_SESSION['tickets']['senior'] * 32, 2); ?> €</span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['selected_date'])): ?>
                            <div class="price-item date-info">
                                <span>Date de visite</span>
                                <span><?php echo date('d/m/Y', strtotime($_SESSION['selected_date'])); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php 
                        // Afficher si c'est un tarif weekend ou semaine
                        $isWeekend = date('N', strtotime($_SESSION['selected_date'])) >= 6;
                        ?>
                        <div class="price-item tarif-info">
                            <span>Type de tarif</span>
                            <span><?php echo $isWeekend ? 'Weekend (+20%)' : 'Semaine (-10%)'; ?></span>
                        </div>

                        <div class="price-total">
                            <span>Total à payer</span>
                            <span><?php echo $_SESSION['total']; ?></span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Payer maintenant</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script>
    const TICKET_PRICES = {
        adult: 35,
        child: 28,
        senior: 32
    };

    const PEAK_PRICE_MULTIPLIER = 1.2;
    const OFF_PEAK_PRICE_MULTIPLIER = 0.9;

    let currentDate = new Date();

    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation du calendrier
        updateCalendar(currentDate);
        
        // Gestion des boutons de navigation des mois
        document.getElementById('prevMonth').addEventListener('click', function(e) {
            e.preventDefault();
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar(currentDate);
        });
        
        document.getElementById('nextMonth').addEventListener('click', function(e) {
            e.preventDefault();
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar(currentDate);
        });
        
        // Gestion des boutons + et -
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const input = this.parentElement.querySelector('.quantity-input');
                let value = parseInt(input.value) || 0;
                
                if (this.classList.contains('plus')) {
                    if (value < parseInt(input.getAttribute('max'))) {
                        value++;
                    }
                } else {
                    if (value > parseInt(input.getAttribute('min'))) {
                        value--;
                    }
                }
                
                input.value = value;
                calculateTotal();
                updateCalendarPrices();
                checkContinueButton();
            });
        });

        // Gestion du bouton Continuer
        if (document.getElementById('continueBtn')) {
            document.getElementById('continueBtn').addEventListener('click', function(e) {
                e.preventDefault();
                
                const adultTickets = document.querySelector('[name="adult_tickets"]').value;
                const childTickets = document.querySelector('[name="child_tickets"]').value;
                const seniorTickets = document.querySelector('[name="senior_tickets"]').value;
                const selectedDate = document.querySelector('.calendar-day.selected');
                const totalAmount = document.getElementById('total-amount').textContent;
                
                if (!selectedDate) {
                    alert('Veuillez sélectionner une date');
                    return;
                }
                
                fetch('save_tickets.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        adult: parseInt(adultTickets),
                        child: parseInt(childTickets),
                        senior: parseInt(seniorTickets),
                        date: selectedDate.dataset.date,
                        total: totalAmount
                    })
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          window.location.href = 'reservation.php?etape=infos';
                      }
                  });
            });
        }
    });

    function calculateTotal() {
        let baseTotal = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const price = parseFloat(input.getAttribute('data-price'));
            baseTotal += quantity * price;
        });
        
        const selectedDay = document.querySelector('.calendar-day.selected');
        if (selectedDay) {
            const date = new Date(selectedDay.dataset.date);
            const isWeekend = date.getDay() === 0 || date.getDay() === 6;
            const multiplier = isWeekend ? PEAK_PRICE_MULTIPLIER : OFF_PEAK_PRICE_MULTIPLIER;
            const finalTotal = baseTotal * multiplier;
            document.getElementById('total-amount').textContent = finalTotal.toFixed(2) + '€';
            return finalTotal;
        } else {
            document.getElementById('total-amount').textContent = '0.00€';
            return 0;
        }
    }

    function updateCalendar(date) {
        const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                           'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        
        document.getElementById('currentMonth').textContent = 
            `${monthNames[date.getMonth()]} ${date.getFullYear()}`;
        
        const calendar = document.getElementById('calendar');
        calendar.innerHTML = '';
        
        const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        
        let startingDay = firstDay.getDay();
        if (startingDay === 0) startingDay = 7;
        
        // Jours vides du début
        for (let i = 1; i < startingDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day empty';
            calendar.appendChild(emptyDay);
        }
        
        // Jours du mois
        for (let day = 1; day <= lastDay.getDate(); day++) {
            const currentDay = new Date(date.getFullYear(), date.getMonth(), day);
            const dayDiv = document.createElement('div');
            dayDiv.className = 'calendar-day';
            
            if (currentDay < new Date()) {
                dayDiv.classList.add('disabled');
            } else {
                dayDiv.addEventListener('click', () => selectDate(dayDiv));
            }
            
            dayDiv.dataset.date = currentDay.toISOString().split('T')[0];
            
            const dayNumber = document.createElement('div');
            dayNumber.textContent = day;
            dayDiv.appendChild(dayNumber);
            
            const priceDiv = document.createElement('div');
            priceDiv.className = 'day-price';
            dayDiv.appendChild(priceDiv);
            
            calendar.appendChild(dayDiv);
        }
        
        updateCalendarPrices();
    }

    function updateCalendarPrices() {
        const baseTotal = calculateBaseTotal();
        
        document.querySelectorAll('.calendar-day:not(.empty):not(.disabled)').forEach(day => {
            const date = new Date(day.dataset.date);
            const isWeekend = date.getDay() === 0 || date.getDay() === 6;
            const multiplier = isWeekend ? PEAK_PRICE_MULTIPLIER : OFF_PEAK_PRICE_MULTIPLIER;
            const dayTotal = baseTotal * multiplier;
            
            const priceDiv = day.querySelector('.day-price');
            if (priceDiv) {
                priceDiv.textContent = dayTotal.toFixed(2) + '€';
                priceDiv.className = `day-price ${isWeekend ? 'peak-price' : 'off-peak-price'}`;
                
                if (day.classList.contains('selected')) {
                    document.getElementById('total-amount').textContent = dayTotal.toFixed(2) + '€';
                }
            }
        });
    }

    function selectDate(element) {
        if (!element.classList.contains('disabled')) {
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.classList.remove('selected');
            });
            element.classList.add('selected');
            
            const priceDiv = element.querySelector('.day-price');
            if (priceDiv) {
                document.getElementById('total-amount').textContent = priceDiv.textContent;
            }
            
            checkContinueButton();
        }
    }

    function checkContinueButton() {
        const selectedDate = document.querySelector('.calendar-day.selected');
        const total = calculateTotal();
        const continueBtn = document.getElementById('continueBtn');
        
        if (selectedDate && total > 0) {
            continueBtn.disabled = false;
            continueBtn.classList.remove('disabled');
        } else {
            continueBtn.disabled = true;
            continueBtn.classList.add('disabled');
        }
    }

    function updateCardDisplay(input, displayId) {
        const display = document.getElementById(displayId);
        if (displayId === 'cardNumberDisplay') {
            display.textContent = input.value.replace(/(\d{4})/g, '$1 ').trim() || '**** **** **** ****';
        } else {
            display.textContent = input.value || (displayId === 'cvvDisplay' ? '***' : 'MM/YY');
        }
    }

    function flipCard(flip) {
        document.getElementById('creditCard').classList.toggle('flipped', flip);
    }

    // Formatage automatique de la date d'expiration
    document.getElementById('expiry').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0,2) + '/' + value.slice(2);
        }
        e.target.value = value;
    });

    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const cardNumber = document.getElementById('cardNumber').value;
        const expiry = document.getElementById('expiry').value;
        const cvv = document.getElementById('cvv').value;
        
        // Validation basique
        if (cardNumber.length !== 16) {
            alert('Le numéro de carte doit contenir 16 chiffres');
            return;
        }
        
        if (!/^\d{2}\/\d{2}$/.test(expiry)) {
            alert('Format de date d\'expiration invalide (MM/YY)');
            return;
        }
        
        if (cvv.length !== 3) {
            alert('Le CVV doit contenir 3 chiffres');
            return;
        }
        
        // Si tout est valide, soumettre le formulaire
        this.submit();
    });

    // Amélioration du formatage du numéro de carte
    document.getElementById('cardNumber').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
        updateCardDisplay(this, 'cardNumberDisplay');
    });

    function calculateBaseTotal() {
        let total = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const price = parseFloat(input.getAttribute('data-price'));
            total += quantity * price;
        });
        return total;
    }

    document.getElementById('visitorsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Vérifier si tous les champs requis sont remplis
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });
        
        if (isValid) {
            this.submit();
        } else {
            alert('Veuillez remplir tous les champs obligatoires');
        }
    });
    </script>
</body>
</html> 