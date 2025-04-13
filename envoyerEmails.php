<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    die("Accès non autorisé");
}

// Vérifier si les données nécessaires sont présentes
if (!isset($_POST['fromEmail']) || !isset($_POST['emailSubject']) || !isset($_POST['emailContent'])) {
    die("Données manquantes pour l'envoi des emails");
}

// Récupération des données du formulaire
$fromEmail = filter_var($_POST['fromEmail'], FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars($_POST['emailSubject']);
$messageContent = htmlspecialchars($_POST['emailContent']);

// Connexion à la base de données
$conn = mysqli_connect("localhost", "Pierre", "Mdp_morane1", "parc");
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupération des emails
$sql = "SELECT email FROM utilisateurs WHERE email IS NOT NULL";
$result = mysqli_query($conn, $sql);

$nb = 0;
$success = [];
$failures = [];

while ($row = mysqli_fetch_assoc($result)) {
    $to = $row['email'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'laforestpierre1@gmail.com'; // 🔁 Remplace par ton adresse Gmail
        $mail->Password = 'zcsh jjeg xvfy hiin '; // 🔁 Remplace par ton mot de passe d'application Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($fromEmail, 'Parc d\'Attraction');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $messageContent;

        // Pièce jointe si présente
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
        }

        $mail->send();
        $nb++;
        $success[] = $to;

    } catch (Exception $e) {
        $failures[] = "$to → " . $mail->ErrorInfo;
    }
}

// Résultat HTML
$response = "<strong>Résumé de l'envoi :</strong><br>";
$response .= "$nb email(s) envoyé(s).<br><br>";

if (!empty($success)) {
    $response .= "<strong>Succès :</strong><br>" . implode("<br>", $success) . "<br><br>";
}
if (!empty($failures)) {
    $response .= "<strong>Échecs :</strong><br>" . implode("<br>", $failures);
}

echo $response;

mysqli_close($conn);
?>
