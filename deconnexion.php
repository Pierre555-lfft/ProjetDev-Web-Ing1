<?php
//Permet la deconnexion de l'utilisateur
session_start(); // Démarre la session pour pouvoir utiliser les variables de session plus tard
session_destroy();  // Détruit toutes les données de session
header('Location: connexion.php'); //redirige vers connexion.php
exit();
?>
