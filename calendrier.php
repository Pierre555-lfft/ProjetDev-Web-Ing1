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
  <link rel="stylesheet" href="styles.css">
  <style>
    .calendrier {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 10px;
      margin-top: 30px;
    }
    .jour {
      background-color: #3a4a7f;
      padding: 10px;
      text-align: center;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h2>Choisissez une date</h2>
  <p>Nombre total de billets : <?= $totalBillets ?></p>
  <div id="prixTotal">Prix total : 0 €</div>

  <div class="calendrier" id="calendrier">
    <?php
    // Simuler les prix dynamiques du calendrier
    $jours = 30;
    for ($i = 1; $i <= $jours; $i++) {
      $prix = ($i % 7 == 5 || $i % 7 == 6) ? 73 : 64.5;
      echo "<div class='jour' data-prix='$prix'> $i avril<br>$prix €</div>";
    }
    ?>
  </div>

  <script>
    const jours = document.querySelectorAll('.jour');
    const prixDiv = document.getElementById('prixTotal');
    const totalBillets = <?= $totalBillets ?>;

    jours.forEach(jour => {
      jour.addEventListener('click', () => {
        const prix = parseFloat(jour.getAttribute('data-prix'));
        const total = prix * totalBillets;
        prixDiv.textContent = "Prix total : " + total.toFixed(2) + " €";
      });
    });
  </script>
</body>
</html>
