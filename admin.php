<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Park d'attraction</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="admin.css" />
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
        <p class="textepresentation">Bonjour <?php echo isset($_SESSION['login']) ? $_SESSION['login'] : 'Administrateur'; ?></p>
      </div>
      <br>
      
     <!-- Inclusion du fichier basPage.php pour afficher le bas de page -->
     <?php
     include "basPage.php";
     ?>
    </body>
</html>

