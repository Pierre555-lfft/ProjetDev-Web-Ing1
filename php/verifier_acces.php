<?php
session_start();
require_once('includes/config.php');

function verifierAccesAttraction($bracelet_id, $attraction_id) {
    global $conn;
    
    // Récupérer les informations du visiteur et de l'attraction
    $sql = "SELECT b.*, p.*, a.* 
            FROM bracelets b
            JOIN reservations r ON b.reservation_id = r.id
            JOIN profils_visiteurs p ON r.user_id = p.user_id
            JOIN attractions a ON a.id = ?
            WHERE b.id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $attraction_id, $bracelet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return ["autorise" => false, "message" => "Données non trouvées"];
    }
    
    $data = $result->fetch_assoc();
    
    // Vérifier la taille
    if ($data['taille'] < $data['taille_minimum']) {
        return ["autorise" => false, "message" => "Taille insuffisante pour cette attraction"];
    }
    
    if ($data['taille_maximum'] && $data['taille'] > $data['taille_maximum']) {
        return ["autorise" => false, "message" => "Taille trop grande pour cette attraction"];
    }
    
    return ["autorise" => true, "message" => "Accès autorisé"];
} 