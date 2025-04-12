<!DOCTYPE html>
<html>
<head>
    <title>Présentation du parc</title>
    <link rel="icon" href="images/logo.jpeg">
    <!-- lien pour le logo de page-->
    <link rel="stylesheet" href="presentation.css">
    <script type="text/javascript" src="Fonctions.js"></script>
</head>
<body>
   <!-- Inclusion du haut de page -->
    <?php
      include "hautPage.php";
    ?>
    <!-- Affiche la zone de connexion -->
    <div class="milieu">
    <h2>Présentation du parc</h2>
     <br>
     <br>
     <p>Le parc Bagatelle est un parc de loisirs situé à Bagatelle, en France. Il est connu pour ses attractions de type "ride" et ses manèges traditionnels. Le parc propose également des spectacles et des animations pour tous les âges.</p>
     <br>
     <p>Le parc est ouvert tous les jours de la semaine, sauf le lundi. Les horaires d'ouverture sont les suivants :</p>
     <br>
     <p>Matin : 10h00 - 12h00</p>
     <p>Après-midi : 14h00 - 18h00</p>
     <p>Soir : 19h00 - 21h00</p>
     <br>
     <p>Le prix d'entrée est de 10€ pour les adultes et 5€ pour les enfants.</p>
     </div>

    <!-- Nouvelle div pour le carrousel -->
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-images">
                <img src="images/attraction1.jpg" alt="Attraction 1">
                <img src="images/attraction2.jpeg" alt="Attraction 2">
                <img src="images/attraction3.jpg" alt="Attraction 3">
                <img src="images/attraction4.jpeg" alt="Attraction 4">
            </div>
        </div>
    </div>

    <div class="plan">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d<?php
            // Génère des coordonnées aléatoires
            $lat = rand(-90, 90); // Latitude entre -90 et 90
            $lng = rand(-180, 180); // Longitude entre -180 et 180
            $zoom = rand(3, 10); // Niveau de zoom aléatoire
            echo "1000000!2d" . $lng . "!3d" . $lat . "!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0";
        ?>" 
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>

  </body>
  
</html>

