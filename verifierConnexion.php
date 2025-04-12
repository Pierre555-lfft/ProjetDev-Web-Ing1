<?php
session_start();

if (!empty($_POST['login']) && !empty($_POST['mdp'])) {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Paramètres de connexion à la base de données
    $host = 'localhost';
    $user = 'Lucas';  // utilisateur par défaut
    $password = 'luKm@9025';   // mot de passe vide par défaut pour XAMPP/WAMP
    $database = 'bdd';

    // Vérification pour l'utilisateur 'simple'
    if ($login === 'simple' && $mdp === 'simple123') {
        $_SESSION['login'] = 'simple';
        $_SESSION['type'] = 'simple';
        $_SESSION['connecte'] = true;
        header('Location: accueil.php');
        exit();
    } 
    // Vérification pour l'admin
    else if ($login === 'admin' && $mdp === 'admin123') {
        $_SESSION['login'] = 'admin';
        $_SESSION['connecte'] = true;
        header('Location: admin.php');
        exit();
    }
    // Authentification échouée
    else {
        $_SESSION['erreur'] = "Login ou mot de passe incorrect";
        header('Location: connexion.php');
        exit();
    }
} else {
    header('Location: connexion.php');
    exit();
}
?>
