<!DOCTYPE html>
<html>
    <head>
        <title>Park d'attraction</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="accueil.css" />
        <!-- lien pour le logo de page-->
   	    <link rel="icon" href="logo.jpeg">
    </head>
    <body>
      <!-- Inclusion du fichier hautPage.php pour afficher le menu -->
      <?php
      include "hautPage.php";
      ?>
      <br>
      <!-- Titre de présentation -->
      <div class="z1">
        <p class="textepresentation">Page Admin</p>
        <br>
        <button type="submit" class="btnDeconnexion" onclick="deconnexion()">Déconnexion</button>
      </div>
      <br>
      
     <!-- Inclusion du fichier basPage.php pour afficher le bas de page -->
     <?php
     include "basPage.php";
     ?>
    </body>
</html>

