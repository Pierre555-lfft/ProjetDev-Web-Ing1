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
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'actualite' ? 'active' : ''; ?>" onclick="actualite()">Présentation</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'presentation' ? 'active' : ''; ?>" onclick="presentation()">Billetterie</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'activite' ? 'active' : ''; ?>" onclick="activite()">Activités</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'galerie' ? 'active' : ''; ?>" onclick="galerie()">Objets Connectés</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'NousContacter' ? 'active' : ''; ?>" onclick="nousContacter()">Nous Contacter</button>
                    <?php
                        if ($_SESSION['user'] === 'admin') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'pageMembre' ? 'active' : '') . "' onclick='membre()'>Espace Client</button>";
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'upload' ? 'active' : '') . "' onclick='admin()'>Espace Admin</button>";
                        }
                        if ($_SESSION['user'] === 'membre') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'pageMembre' ? 'active' : '') . "' onclick='membre()'>Espace Client</button>";
                        }
                    ?>
                </li>
            </ul>
        </nav>
        <!-- Permet de gérer la connexion en fonction du statut de l'utilisateur-->
        <form id="formConnexion" action="<?php
            if (isset($_SESSION['user']) && ($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'membre')) {
                echo 'deconnexion.php';
            } else {
                echo 'connexion.php';
            }?>" method="post">
            <p><input type="submit" class="connexion <?php echo ($current_page == 'connexion' || $current_page == 'admin' || $current_page == 'membre') ? 'active' : ''; ?>" 
                value="<?php echo (isset($_SESSION['user']) && ($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'membre')) ? 'Se déconnecter' : 'Se connecter'; ?>"></p>
        </form>

    </div>
</body>
</html>

