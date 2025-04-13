<?php
session_start();

// Configuration de la base de données
$host = "localhost";
$user = "Pierre";
$password = "Mdp_morane1";
$dbname = "parc";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification que tous les champs requis sont présents
    $required_fields = ['login', 'mdp', 'email', 'nom', 'prenom', 'adresse'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("Le champ $field est requis.");
        }
    }

    // Récupération et nettoyage des données
    $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
    $mdp = md5($_POST['mdp']); // Utilisation de MD5 comme dans votre base de données
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    $adresse = filter_var($_POST['adresse'], FILTER_SANITIZE_STRING);
    
    // Vérification si l'email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("L'adresse email n'est pas valide.");
    }

    // Vérification si le login existe déjà
    $stmt = $conn->prepare("SELECT COUNT(*) FROM utilisateurs WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetchColumn() > 0) {
        throw new Exception("Cet identifiant est déjà utilisé.");
    }

    // Préparation et exécution de la requête d'insertion
    $sql = "INSERT INTO utilisateurs (login, mdp, email, nom, prenom, adresse, type_compte) 
            VALUES (:login, :mdp, :email, :nom, :prenom, :adresse, 'client')";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':login' => $login,
        ':mdp' => $mdp,
        ':email' => $email,
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':adresse' => $adresse
    ]);

    // Message de succès
    $_SESSION['success_message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    header("Location: connexion.php");
    exit();

} catch (Exception $e) {
    // En cas d'erreur, stockage du message d'erreur et redirection
    $_SESSION['error_message'] = "Erreur lors de l'inscription : " . $e->getMessage();
    header("Location: contact.php");
    exit();
}
?> 