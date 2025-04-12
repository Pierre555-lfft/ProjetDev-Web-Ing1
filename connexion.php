<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="icon" href="images/logo.jpeg">
    <!-- lien pour le logo de page-->
    <link rel="stylesheet" href="connexion.css">
    <script type="text/javascript" src="Fonctions.js"></script>
</head>
<body>
   <!-- Inclusion du haut de page -->
    <?php
      include "hautPage.php";
    ?>
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

