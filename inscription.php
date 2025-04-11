<?php
session_start();
require_once('includes/config.php');

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    try {
        if ($password !== $password_confirm) {
            throw new Exception("Les mots de passe ne correspondent pas");
        }
        
        // Vérifier si l'utilisateur existe déjà
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Cet identifiant existe déjà");
        }
        
        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Créer le nouvel utilisateur
        $stmt = $conn->prepare("INSERT INTO utilisateurs (username, password, type_compte) VALUES (?, ?, 'membre')");
        $stmt->bind_param("ss", $username, $hashed_password);
        
        if ($stmt->execute()) {
            $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
            header("refresh:2;url=connexion.php"); // Redirection après 2 secondes
        } else {
            throw new Exception("Erreur lors de l'inscription");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/logo3.jpg">
    <style>
        .inscription-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>
    
    <div class="inscription-container">
        <h2>Créer un compte</h2>
        <?php 
        if($error) echo "<p class='error'>$error</p>";
        if($success) echo "<p class='success'>$success</p>";
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Identifiant:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe:</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>
            
            <button type="submit" class="btn">S'inscrire</button>
        </form>
        
        <form action="connexion.php">
            <button type="submit" class="btn">Retour à la connexion</button>
        </form>
    </div>
</body>
</html> 