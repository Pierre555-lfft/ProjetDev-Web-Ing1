<!DOCTYPE html>
<html>
<head>
    <title>Tarifs</title>
    
    <!-- lien pour le logo de page-->
    <link rel="stylesheet" href="tarifs.css">
    <script type="text/javascript" src="Fonctions.js"></script>
</head>
<body>
   <!-- Inclusion du haut de page -->
    <?php
      include "hautPage.php";
    ?>
    <!-- Vidéo de fond -->
    <video autoplay muted loop id="video-background">
      <source src="videos/montagne_russe_animation.mp4" type="video/mp4">
      Votre navigateur ne supporte pas la vidéo HTML5.
    </video>

    <!-- Ton contenu HTML habituel ici -->
    <div class="milieu">
      <h2>Nos Tarifs</h2>
      <p>Découvrez nos tarifs pour toute la famille !</p>
      
      <table class="tarifs-table">
        <thead>
          <tr>
            <th>Catégorie</th>
            <th>Prix</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Adultes (12+)</td>
            <td>52€</td>
          </tr>
          <tr>
            <td>Enfants (4-11)</td>
            <td>44€</td>
          </tr>
          <tr>
            <td>Seniors (60+)</td>
            <td>44€</td>
          </tr>
          <tr>
            <td>Tarif réduit spécial</td>
            <td>44€</td>
          </tr>
        </tbody>
      </table>

      <br>
      <a href="contact.php" class="inscription-link">S'inscrire</a>
    </div>
    
    <!-- Inclusion du bas de page -->
    <?php
      include "basPage.php";
    ?>
  </body>
</html>

