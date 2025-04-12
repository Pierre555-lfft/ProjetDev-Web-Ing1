<!DOCTYPE html>
<html>
    <head>
        <title>Accueil - Parc d'attractions</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="accueil.css">
        <link rel="icon" href="logo.jpeg">
        <!-- lien pour le logo de page-->
        <link rel="icon" href="logo.jpeg">
    </head>
    <body>
      <!-- Inclusion du fichier hautPage.php pour afficher le menu -->
      <?php
      include "hautPage.php";
      ?>
       <!-- Vidéo de fond -->
    <video autoplay muted loop id="video-background">
      <source src="videos/montagne_russe_animation.mp4" type="video/mp4">
      Votre navigateur ne supporte pas la vidéo HTML5.
    </video>

      <br>
      <!-- Titre de présentation -->
      <div class="z1">
        <p class="textepresentation">Bienvenue dans notre Parc d'Attractions</p>
      </div>
      <br>
      
     <!-- Inclusion du fichier basPage.php pour afficher le bas de page -->
     <?php
     include "basPage.php";
     ?>

    <div class="banner">
        <div>
            
        </div>
    </div>

    <div class="attractions-grid">
        <!-- Contenu repris de index.html avec les images et descriptions -->
    </div>
    </body>
</html>

