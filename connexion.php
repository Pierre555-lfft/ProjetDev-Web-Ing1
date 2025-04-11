<?php
session_start();
require_once('includes/config.php');

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        // Afficher les valeurs pour débogage
        echo "Login tenté : " . $username . "<br>";
        echo "Mot de passe tenté : " . $password . "<br>";
        
        // Vérifier si l'utilisateur existe
        $sql = "SELECT * FROM membres WHERE login = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "Utilisateur trouvé dans la BD<br>";
            echo "Mot de passe stocké : " . $user['mdp'] . "<br>";
        } else {
            echo "Aucun utilisateur trouvé avec ce login<br>";
        }
        
        // Continuer avec la vérification normale...
        $sql = "SELECT * FROM membres WHERE login = ? AND mdp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($username === 'admin') {
                $_SESSION['user'] = 'admin';
            } elseif ($username === 'complexe') {
                $_SESSION['user'] = 'complexe';
            } else {
                $_SESSION['user'] = 'membre';
            }
            $_SESSION['user_id'] = $user['id'];
            header("Location: accueil.php");
            exit();
        } else {
            $error = "Identifiants incorrects";
        }
    } catch (Exception $e) {
        $error = "Erreur de connexion: " . $e->getMessage();
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
                <label for="username">Identifiant:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Se connecter</button>
        </form>
        
        <form action="inscription.php">
            <button type="submit" class="btn">Créer un compte</button>
        </form>
    </div>
</body>
</html>

