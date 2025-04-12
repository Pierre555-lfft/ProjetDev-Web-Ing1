<!DOCTYPE html>
<html>
<head>
    <title>NousContacter</title>
    
    <!-- lien pour le logo de page-->
    <link rel="stylesheet" href="contact.css">
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
    
    <div class="contact">
      <h2>Nous contacter</h2>
      <br>
      <p id="Facebook"> Notre Facebook</p>
      <br>
      <img id="imgRes1" src="images/facebook.png">
      <br>
      <br>
      <p id="Instagram">Notre Instagram</p>
      <br>
      <img id="imgRes2" src="images/instagram.png">
      <br>
      <br>
      <p id="Mail">Notre Mail</p>
      <br>
      <img id="imgRes3" src="images/mail.png">

      
      
    </div>
   
    <!-- Affiche la zone d'inscription -->
    <div class="inscription">
    <h2>S'inscrire</h2>
    
     <form class="formulaire" action="inscriptionBDD.php" method="POST">
       <label for="nom">Nom</label>
       <p><input type="text" name="nom" id="nom" required></p>
       <br>
       <label for="prenom">Prénom</label>
       <p><input type="text" name="prenom" id="prenom" required></p>
       <br>
       <label for="age">Age</label>
       <p><input type="number" name="age" id="age" min="1" max="120" required></p>
       <br>
       <label for="email">Adresse email</label>
       <p><input type="email" name="email" id="email" required></p>
       <br>
       <p><input class="btnConnexion" type="submit" value="Envoyer"></p>
       <br>
     </form>
   </div>
   <?php
    include "basPage.php"
   ?>
  </body>
</html>

