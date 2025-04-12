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
    
     <form class="formulaire" action="verifierConnexion.php" method="POST">
       <label for="login">Nom</label>
       <p><input type="text" name="login"></p>
       <br>
       <label for="mdp">Prénom</label>
       <p><input type="password" name="mdp"></p>
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

