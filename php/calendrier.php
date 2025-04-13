<?php
// Récupérer les données du formulaire
$adultes = $_POST['adultes'];
$enfants = $_POST['enfants'];
$seniors = $_POST['seniors'];
$reduits = $_POST['reduits'];

$totalBillets = $adultes + $enfants + $seniors + $reduits;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de la date</title>
    <link rel="stylesheet" href="../css/calendrier.css">
    <link rel="icon" href="../images/logo3.jpg">
    <script type="text/javascript" src="../js/Fonctions.js"></script>
</head>
<body>
    <?php include "hautPage.php"; ?>

    <!-- Vidéo de fond -->
    <video autoplay muted loop id="video-background">
      <source src="../videos/montagne_russe_animation.mp4" type="video/mp4">
      Votre navigateur ne supporte pas la vidéo HTML5.
    </video>

    <div class="calendrier-container">
        <h2>Choisissez une date</h2>
        <div class="info-billets">
            <p>Nombre total de billets : <span class="highlight"><?= $totalBillets ?></span></p>
            <div id="prixTotal">Prix total : <span class="highlight">0 €</span></div>
        </div>

        <div class="calendrier" id="calendrier">
            <?php
            // Simuler les prix dynamiques du calendrier
            $jours = 30;
            for ($i = 1; $i <= $jours; $i++) {
                $prix = ($i % 7 == 5 || $i % 7 == 6) ? 73 : 64.5;
                echo "<div class='jour' data-prix='$prix'>
                        <div class='date'>$i avril</div>
                        <div class='prix'>$prix €</div>
                      </div>";
            }
            ?>
        </div>

        <button class="btnConnexion" onclick="window.location.href='paiement.php'">Continuer vers le paiement</button>
    </div>

    <?php include "basPage.php"; ?>

    <script>
        const jours = document.querySelectorAll('.jour');
        const prixDiv = document.getElementById('prixTotal');
        const totalBillets = <?= $totalBillets ?>;

        jours.forEach(jour => {
            jour.addEventListener('click', () => {
                // Enlever la classe active de tous les jours
                jours.forEach(j => j.classList.remove('active'));
                // Ajouter la classe active au jour sélectionné
                jour.classList.add('active');
                
                const prix = parseFloat(jour.getAttribute('data-prix'));
                const total = prix * totalBillets;
                prixDiv.innerHTML = "Prix total : <span class='highlight'>" + total.toFixed(2) + " €</span>";
            });
        });
    </script>
</body>
</html>
