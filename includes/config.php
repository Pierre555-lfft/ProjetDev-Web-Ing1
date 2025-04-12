<?php
// Configuration de la base de données
$db_host = "localhost";
$db_name = "bdd";
$db_user = "Lucas";
$db_pass = "luKm@9025";

// Connexion à la base de données
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        throw new Exception("Erreur de connexion à la base de données");
    }
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Configuration des sessions
ini_set('session.cookie_lifetime', 0);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Uniquement si HTTPS
ini_set('session.gc_maxlifetime', 3600); // 1 heure

// Démarrage de la session si pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fonction pour vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fonction pour vérifier la validité de la session
function checkSession() {
    if (!isLoggedIn()) {
        header('Location: connexion.php');
        exit();
    }
    
    // Régénérer l'ID de session périodiquement pour la sécurité
    if (!isset($_SESSION['last_regeneration']) || 
        time() - $_SESSION['last_regeneration'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
?> 