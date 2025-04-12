<?php
session_start();
require_once('includes/config.php');

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    
    // Vérification pour tous les utilisateurs
    if (($login === 'simple' && $mdp === 'simple123') ||
        ($login === 'complexe' && $mdp === 'complexe123') ||
        ($login === 'admin' && $mdp === 'admin123')) {
        
        // Définir le type d'utilisateur
        if ($login === 'admin') {
            $_SESSION['user'] = 'admin';
        } elseif ($login === 'complexe') {
            $_SESSION['user'] = 'complexe';
        } else {
            $_SESSION['user'] = 'membre';
        }
        
        $_SESSION['user_id'] = 1;
        header("Location: accueil.php");
        exit();
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/logo3.jpg">
    <style>
        .login-container {
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
    </style>
</head>
<body>
    <?php include('hautPage.php'); ?>
    
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="login">Identifiant:</label>
                <input type="text" id="login" name="login" required>
            </div>
            
            <div class="form-group">
                <label for="mdp">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" required>
            </div>
            
            <button type="submit" class="btn">Se connecter</button>
        </form>
        
        <form action="inscription.php">
            <button type="submit" class="btn">Créer un compte</button>
        </form>
    </div>
</body>
</html>
