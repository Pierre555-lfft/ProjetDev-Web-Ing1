<?php
session_start();

if (!empty($_POST['login']) && !empty($_POST['mdp'])) {

    $login = $_POST['login'];
    $password = $_POST['mdp'];

    // Connexion à la base de données
    $host = 'localhost';
    $user = 'Lucas';
    $db_password = 'luKm@9025'; // mot de passe MySQL (vide si WAMP/XAMPP)
    $database = 'parcAttraction'; // à adapter avec le vrai nom de ta base

    $conn = mysqli_connect($host, $user, $db_password, $database);

    if (!$conn) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Vérification admin
    $sql_admin = "SELECT * FROM admin WHERE login = ? AND mdp = ?";
    $stmt = mysqli_prepare($conn, $sql_admin);
    mysqli_stmt_bind_param($stmt, "ss", $login, $hashedPassword);
    $hashedPassword = md5($password);
    mysqli_stmt_execute($stmt);
    $result_admin = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_admin) > 0) {
        $_SESSION['user'] = 'admin';
        header('Location: admin.php');
        exit();
    }

    // Vérification membre
    $sql_membre = "SELECT * FROM membres WHERE login = ? AND mdp = ?";
    $stmt = mysqli_prepare($conn, $sql_membre);
    mysqli_stmt_bind_param($stmt, "ss", $login, $hashedPassword);
    mysqli_stmt_execute($stmt);
    $result_membre = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_membre) > 0) {
        $_SESSION['user'] = 'membre';
        header('Location: objets_connectes.php');
        exit();
    }

    // Si aucun compte trouvé
    header('Location: connexion.php');
    exit();

} else {
    header('Location: connexion.php');
    exit();
}
?>
