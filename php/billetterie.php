<!-- index.html -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Billetterie CY PARC</title>
  <link rel="stylesheet" href="../css/billetterie.css">
  <link rel="icon" href="../images/logo3.jpg">
  <script type="text/javascript" src="../js/Fonctions.js"></script>
</head>
<body>
  <!-- Inclusion du haut de page -->
  <?php
    include "hautPage.php";
  ?>
 <!-- Vidéo de fond -->
 <video autoplay muted loop id="video-background">
      <source src="../videos/montagne_russe_animation.mp4" type="video/mp4">
      Votre navigateur ne supporte pas la vidéo HTML5.
    </video>
    
  <div class="billetterie-container">
    <h2>Réservation de billets</h2>
    
    <form id="ticketForm" action="calendrier.php" method="POST" class="formulaire">
      <div class="tarif-group">
        <h3>Veuillez sélectionner vos billets</h3>
        
        <div class="tarif">
          <label for="adultes">Adultes (12+)</label>
          <div class="prix">52€</div>
          <div class="input-container">
            <input type="number" name="adultes" id="adultes" min="0" value="0" required>
          </div>
        </div>

        <div class="tarif">
          <label for="enfants">Enfants (4-11)</label>
          <div class="prix">44€</div>
          <div class="input-container">
            <input type="number" name="enfants" id="enfants" min="0" value="0" required>
          </div>
        </div>

        <div class="tarif">
          <label for="seniors">Seniors (60+)</label>
          <div class="prix">44€</div>
          <div class="input-container">
            <input type="number" name="seniors" id="seniors" min="0" value="0" required>
          </div>
        </div>

        <div class="tarif">
          <label for="reduits">Tarif réduit spécial</label>
          <div class="prix">44€</div>
          <div class="input-container">
            <input type="number" name="reduits" id="reduits" min="0" value="0" required>
          </div>
        </div>
      </div>

      <div class="total-section">
        <div class="total-label">Total :</div>
        <div id="total-price">0 €</div>
      </div>

      <input type="submit" class="btnConnexion" value="Continuer la réservation">
    </form>
  </div>

  <?php
    include "basPage.php";
  ?>

  
</body>
</html>
