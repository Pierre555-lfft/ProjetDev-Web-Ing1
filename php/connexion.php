<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="icon" href="../images/logo.jpeg">
    <!-- lien pour le logo de page-->
    <link rel="stylesheet" href="../css/connexion.css">
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
    
    <!-- Affiche la zone de connexion -->
    <div class="milieu">
    <h2>Connexion</h2>
     <form class="formulaire" action="verifierConnexion.php" method="POST">
       <label for="login">Login</label>
       <p><input type="text" name="login"></p>
       <br>
       <label for="mdp">Mot de passe</label>
       <p><input type="password" name="mdp"></p>
       <br>
       <p><input class="btnConnexion" type="submit" value="Connexion"></p>
       <br>
     </form>
   </div>
   <?php
    include "basPage.php"
   ?>
  </body>
</html>

