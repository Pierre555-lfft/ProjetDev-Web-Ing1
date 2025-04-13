<?php
session_start();

if (!empty($_POST['login']) && !empty($_POST['mdp'])) {
    $login = $_POST['login'];
    $password = $_POST['mdp'];
    $hashedPassword = md5($password); // Remplacer par password_hash() pour plus de sécurité

    // Connexion à la BDD
    $conn = mysqli_connect('localhost', 'Pierre', 'Mdp_morane1', 'parc');

    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM utilisateurs WHERE login = ? AND mdp = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $login, $hashedPassword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        $_SESSION['user'] = $user['type_compte'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['id'] = $user['id'];

        // Redirection selon le type de compte
        switch ($user['type_compte']) {
            case 'admin':
                header('Location: admin.php');
                break;
            case 'employe':
                header('Location: employe.php');
                break;
            case 'client_complet':
                header('Location: accueil.php');
                break;
            case 'client':
                header('Location: accueil.php');
                break;
            default:
                header('Location: connexion.php?erreur=role');
        }
        exit();
    } else {
        header('Location: connexion.php?erreur=1');
        exit();
    }
} else {
    header('Location: connexion.php');
    exit();
}
?>
