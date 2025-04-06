<!DOCTYPE html>
<html>
<head>
    <title>en travaux</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="hautPage.css" />
    <!-- lien pour le logo de page-->
    <link rel="icon" href="images/logo3.jpg">
    <script type="text/javascript" src="Fonctions.js"></script>
</head>
<body>
    <?php
        session_start();
        $current_page = basename($_SERVER['PHP_SELF'], ".php");
    ?>
    <!-- Affichage du menu-->
    <div class="menu">
        <nav>
            <ul>
                <li>
                    <img class="logo" src="images/logo3.jpg" />
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'accueil' ? 'active' : ''; ?>" onclick="accueil()">Accueil</button> <!-- active permet d'indiquer la page active afin de changer sa couleur -->
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'actualite' ? 'active' : ''; ?>" onclick="actualite()">Actualités / Agenda</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'presentation' ? 'active' : ''; ?>" onclick="presentation()">Présentation</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'activite' ? 'active' : ''; ?>" onclick="activite()">Activités</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'galerie' ? 'active' : ''; ?>" onclick="galerie()">Galeries</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'NousContacter' ? 'active' : ''; ?>" onclick="nousContacter()">Nous Contacter</button>
                    <?php
                        if ($_SESSION['user'] === 'admin') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'pageMembre' ? 'active' : '') . "' onclick='membre()'>Espace Membre</button>";
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'upload' ? 'active' : '') . "' onclick='admin()'>Modifications</button>";
                        }
                        if ($_SESSION['user'] === 'membre') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'pageMembre' ? 'active' : '') . "' onclick='membre()'>Espace Membre</button>";
                        }
                    ?>
                </li>
            </ul>
        </nav>
        <!-- Permet de gérer la connexion en fonction du statut de l'utilisateur-->
        <form id="formConnexion" action="<?php
            if ($_SESSION['user'] === 'admin') {
                echo 'admin.php';
            } elseif ($_SESSION['user'] === 'membre') {
                echo 'membre.php';
            } else {
                echo 'connexion.php';
            }?>" method="post">
            <p><input type="submit" class="connexion <?php echo ($current_page == 'connexion' || $current_page == 'admin' || $current_page == 'membre') ? 'active' : ''; ?>" value="Se connecter"></p>
        </form>

    </div>
</body>
</html>

