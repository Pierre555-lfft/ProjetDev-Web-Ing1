<!-- Code de la page d'accueil-->
<!-- auteur : Pierre Laforest-->
<!-- date : 29/03/25-->
 
<!DOCTYPE html>
<html>
    <head>
        <title>Parc d'attraction</title>
        <meta charset="utf-8">
        <!-- lien qui relie cette page au css-->
        <link rel="stylesheet" type="text/css" href="accueil.css" />
        <!-- lien pour le logo de page-->
   	    <link rel="icon" href="logo.jpeg">
    </head>
    <body>
      <!-- Inclusion du fichier hautPage.php pour afficher le menu -->
      <?php
      include "hautPage.php"; // inclusion du haut de page 
      ?>
      <br>
      <!-- Titre de présentation -->
      <div class="z1">
        <p class="textepresentation">Parc d'attraction</p>
      </div>
      <br>
      
     <!-- Inclusion du fichier basPage.php pour afficher le bas de page -->
     <?php
     include "basPage.php"; // inclusion du bas de page
     ?>
    </body>
</html>

