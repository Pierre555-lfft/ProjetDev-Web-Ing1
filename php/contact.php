<!DOCTYPE html>
<html>
<head>
    <title>NousContacter</title>
    
    <!-- lien pour le logo de page-->
    <link rel="stylesheet" href="../css/contact.css">
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
    
    <div class="contact">
      <h2>Nous contacter</h2>
      <br>
      <p id="Facebook"> Notre Facebook</p>
      <br>
        <img id="imgRes1" src="../images/facebook.png">
      <br>
      <br>
      <p id="Instagram">Notre Instagram</p>
      <br>
      <img id="imgRes2" src="../images/instagram.png">
      <br>
      <br>
      <p id="Mail">Notre Mail</p>
      <br>
      <img id="imgRes3" src="../images/mail.png">

      
      <div class="messages">
    <?php
    session_start();
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    ?>
</div>
    </div>
   
    <!-- Affiche la zone d'inscription -->
    <div class="inscription">
    <h2>S'inscrire</h2>
    
     <form class="formulaire" action="inscriptionBDD.php" method="POST">
       <label for="login">Identifiant</label>
       <p><input type="text" name="login" id="login" required></p>
       <br>
       <label for="mdp">Mot de passe</label>
       <p><input type="password" name="mdp" id="mdp" required></p>
       <br>
       <label for="nom">Nom</label>
       <p><input type="text" name="nom" id="nom" required></p>
       <br>
       <label for="prenom">Prénom</label>
       <p><input type="text" name="prenom" id="prenom" required></p>
       <br>
       <label for="email">Adresse email</label>
       <p><input type="email" name="email" id="email" required></p>
       <br>
       <label for="adresse">Adresse</label>
       <p><input type="text" name="adresse" id="adresse" required></p>
       <br>
       <p><input class="btnConnexion" type="submit" value="S'inscrire"></p>
       <br>
     </form>
   </div>
   <?php
    include "basPage.php"
   ?>
  </body>
</html>

