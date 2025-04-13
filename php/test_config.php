<?php
require_once('includes/config.php');

echo "<h2>Test de la configuration</h2>";

// Test de la connexion à la base de données
try {
    $test_query = $conn->query("SELECT 1");
    echo "✅ Connexion à la base de données : OK<br>";
} catch (Exception $e) {
    echo "❌ Erreur de connexion à la base de données : " . $e->getMessage() . "<br>";
}

// Test des sessions
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "✅ Sessions PHP : OK<br>";
} else {
    echo "❌ Erreur avec les sessions PHP<br>";
}

// Test des permissions de la base de données
try {
    $conn->query("SELECT * FROM reservations LIMIT 1");
    echo "✅ Permissions de lecture : OK<br>";
    
    $test_insert = $conn->prepare("INSERT INTO reservations (user_id, date_visite, montant, statut) VALUES (?, ?, ?, ?)");
    $test_insert->bind_param("isds", 1, date('Y-m-d'), 0.00, 'test');
    $test_insert->execute();
    $last_id = $conn->insert_id;
    echo "✅ Permissions d'écriture : OK<br>";
    
    // Nettoyer le test
    $conn->query("DELETE FROM reservations WHERE id = $last_id");
} catch (Exception $e) {
    echo "❌ Erreur de permissions : " . $e->getMessage() . "<br>";
} 