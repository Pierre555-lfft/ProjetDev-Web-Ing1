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
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'presentation' ? 'active' : ''; ?>" onclick="presentation()">Présentation</button>
                    
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'tarifs' ? 'active' : ''; ?>" onclick="tarifs()">Tarifs</button>
                    
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'contact' ? 'active' : ''; ?>" onclick="contact()">Nous Contacter</button>
                    <?php
                        if ($_SESSION['user'] === 'admin') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'pageMembre' ? 'active' : '') . "' onclick='membre()'>Espace Client</button>";
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'admin' ? 'active' : '') . "' onclick='admin()'>Espace Admin</button>";
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'obljets_connectes' ? 'active' : '') . "' onclick='objets_connectes()'>Objets Connectés</button>";
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'billetterie' ? 'active' : '') . "' onclick='billetterie()'>Billetterie</button>";
                        }
                        if ($_SESSION['user'] === 'client') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'pageMembre' ? 'active' : '') . "' onclick='membre()'>Espace Client</button>";
                            
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'billetterie' ? 'active' : '') . "' onclick='billetterie()'>Billetterie</button>";
                        }
                        if ($_SESSION['user'] === 'client_complet') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'gerer' ? 'active' : '') . "' onclick='gerer()'>Espace Client complexe</button>";
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'obljets_connectes' ? 'active' : '') . "' onclick='objets_connectes()'>Objets Connectés</button>";
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'billetterie' ? 'active' : '') . "' onclick='billetterie()'>Billetterie</button>";
                        }
                        if ($_SESSION['user'] === 'employe') {
                            echo "<button type='submit' class='bouttonMenu " . ($current_page == 'gerer' ? 'active' : '') . "' onclick='gerer()'>Espace Client complexe</button>";
                        }
                    ?>
                </li>
            </ul>
        </nav>
         <!-- Permet de gérer la connexion en fonction du statut de l'utilisateur-->
         <form id="formConnexion" action="<?php
                        if (isset($_SESSION['user']) && ($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'client' || $_SESSION['user'] === 'client_complet' || $_SESSION['user'] === 'employe')) {
                            echo 'deconnexion.php';
                        } else {
                            echo 'connexion.php';
                        }?>" method="post">
                        <input type="submit" class="connexion <?php echo ($current_page == 'connexion' || $current_page == 'admin' || $current_page == 'client' || $current_page == 'client_complet' || $current_page == 'employe') ? 'active' : ''; ?>" 
                            value="<?php echo (isset($_SESSION['user']) && ($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'client' || $_SESSION['user'] === 'client_complet' || $_SESSION['user'] === 'employe')) ? 'Se déconnecter' : 'Se connecter'; ?>">
                    </form>

    </div>
</body>
</html>

