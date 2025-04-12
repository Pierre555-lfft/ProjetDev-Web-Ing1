<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>en travaux</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="hautPage.css" />
    <link rel="icon" href="images/logo3.jpg">
    <script type="text/javascript" src="Fonctions.js"></script>
    <style>
        .header-nav {
            background-color: #333;
            padding: 15px;
            color: white;
        }
        .nav-buttons {
            display: flex;
            gap: 10px;
        }
        .nav-btn {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .nav-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
        session_start();
    ?>
    <div class="menu">
        <nav>
            <ul>
                <li>
                    <img class="logo" src="images/logo3.jpg" />
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'accueil' ? 'active' : ''; ?>" onclick="accueil()">Accueil</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'actualite' ? 'active' : ''; ?>" onclick="actualite()">Actualités / Agenda</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'presentation' ? 'active' : ''; ?>" onclick="presentation()">Présentation</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'activite' ? 'active' : ''; ?>" onclick="activite()">Activités</button>
                    <button type="submit" class="bouttonMenu <?php echo $current_page == 'NousContacter' ? 'active' : ''; ?>" onclick="nousContacter()">Nous Contacter</button>
                    <?php
                    if (isset($_SESSION['user'])) {
                        if ($_SESSION['user'] === 'membre') {
                            ?>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'reservation' ? 'active' : ''; ?>" onclick="billetterie()">Prendre sa place</button>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'objets_connectes' ? 'active' : ''; ?>" onclick="objetsConnectes()">Objets connectés</button>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'gestion_bracelet' ? 'active' : ''; ?>" onclick="window.location.href='gestion_bracelet.php'">Mon Bracelet</button>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'deconnexion' ? 'active' : ''; ?>" onclick="deconnexion()">Déconnexion</button>
                            <?php
                        } elseif ($_SESSION['user'] === 'admin') {
                            ?>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'deconnexion' ? 'active' : ''; ?>" onclick="deconnexion()">Déconnexion</button>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'admin' ? 'active' : ''; ?>" onclick="admin()">Administration</button>
                            <?php
                        } elseif ($_SESSION['user'] === 'complexe') {
                            ?>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'gerer' ? 'active' : ''; ?>" onclick="window.location.href='gerer.php'">Gérer</button>
                            <button type="submit" class="bouttonMenu <?php echo $current_page == 'deconnexion' ? 'active' : ''; ?>" onclick="deconnexion()">Déconnexion</button>
                            <?php
                        }
                    } else {
                        ?>
                        <form id="formConnexion" action="connexion.php" method="post">
                            <p><input type="submit" class="connexion <?php echo $current_page == 'connexion' ? 'active' : ''; ?>" value="Se connecter"></p>
                        </form>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html>

