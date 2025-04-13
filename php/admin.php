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
        <link rel="stylesheet" type="text/css" href="../css/admin.css" />
        <script src="../js/Fonctions.js"></script>
        <!-- lien pour le logo de page-->
   	    <link rel="icon" href="../images/logo.jpeg">
    </head>
    <body>
      <!-- Inclusion du fichier hautPage.php pour afficher le menu -->
      <?php
      include "hautPage.php";
      ?>
      <!-- Vidéo de fond -->
    <video autoplay muted loop id="video-background">
      <source src="../videos/montagne_russe_animation.mp4" type="video/mp4">
      Votre navigateur ne supporte pas la vidéo HTML5.
    </video>
      <br>
      <!-- Titre de présentation -->
      <div class="z1">
        <p class="textepresentation">Bonjour <?php echo isset($_SESSION['login']) ? $_SESSION['login'] : 'Administrateur'; ?></p>
      </div>
      <br>
      <div class="modiffier">
      <h1>Espace Admin</h1>
        <br>
        <div class="zone">
          <p class="titre">Gestionnaire de mail</p>
          <br>
          <form id="emailForm">
              <div class="email-settings">
                  <label for="fromEmail">Adresse d'envoi :</label>
                  <input type="email" 
                         id="fromEmail" 
                         name="fromEmail" 
                         required 
                         placeholder="Entrez votre adresse email"
                         pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                         title="Veuillez entrer une adresse email valide">
                  
                  <label for="emailSubject">Sujet du mail :</label>
                  <input type="text" 
                         id="emailSubject" 
                         name="emailSubject" 
                         required 
                         placeholder="Entrez le sujet du mail" 
                         value="Annonce du Parc d'Attraction">
                  
                  <label for="emailContent">Contenu du mail :</label>
                  <textarea id="emailContent" 
                            name="emailContent" 
                            required 
                            rows="5"
                            placeholder="Entrez le contenu du mail">Bonjour,

Ceci est un message automatique du parc d'attraction.
Merci de votre fidélité !

Cordialement,
L'équipe du Parc</textarea>

                  <div class="file-upload-section">
                      <label for="fileInput">Joindre un fichier :</label>
                      <input class="file-input" 
                             id="fileInput" 
                             type="file" 
                             accept=".csv,.xls,.xlsx,.pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                      <p class="file-info">Formats acceptés : CSV, Excel, PDF, Word, Text, Images (JPG, PNG)</p>
                      <p class="file-size-info">Taille maximale : 10 MB</p>
                  </div>
              </div>
          </form>
          <button id="sendEmailsBtn" class="boutton">Envoyer les e-mails à tous les utilisateurs</button>
          <p id="statusMessage"></p>
          <br>
          <button class="boutton" onclick="adhesion()">Voir les demandes d'adhésion</button>
          <br>
          <br>
        </div>
        <br>
        <button class="btnDeconnexion" onclick="Forum()">Formulaire Visiteur</button>
        <br>
        <br>
      </div>
      
     <!-- Inclusion du fichier basPage.php pour afficher le bas de page -->
     <?php
     include "basPage.php";
     ?>
    
    </body>
</html>

