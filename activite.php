<!DOCTYPE html>
<html>
<head>
    <title>Activités</title>
    
    <!-- lien pour le logo de page-->
    <link rel="stylesheet" href="activite.css">
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
      <h2>Nos Activités</h2>
      <p>Découvrez nos manèges, spectacles et animations pour toute la famille !</p>
    </div>
    
<!-- Inclusion du bas de page -->
<?php
      include "basPage.php";
    ?>
  </body>
  
</html>

