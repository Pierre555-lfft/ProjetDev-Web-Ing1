<!DOCTYPE html>
<html>
    <head>
        <title>Accueil - Parc d'attractions</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/style.css">
        <style>
            /* Styles spécifiques repris de index.html */
            .banner {
                background-image: url('pageaccueil.png');
                background-size: cover;
                height: 500px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                text-align: center;
            }

            .attractions-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
                padding: 20px;
            }

            .attraction-card {
                background: white;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }

            .attraction-card img {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }

            .attraction-info {
                padding: 20px;
            }
        </style>
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
        <p class="textepresentation">Parc d'attraction</p>
      </div>
      <br>
      
     <!-- Inclusion du fichier basPage.php pour afficher le bas de page -->
     <?php
     include "basPage.php";
     ?>

    <div class="banner">
        <div>
            <h1>Bienvenue dans notre Parc d'Attractions</h1>
            <p>Découvrez un monde d'émotions et de technologies</p>
        </div>
    </div>

    <div class="attractions-grid">
        <!-- Contenu repris de index.html avec les images et descriptions -->
    </div>
    </body>
</html>

