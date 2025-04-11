<?php
require_once('includes/config.php');

if ($conn->ping()) {
    echo "La connexion à la base de données fonctionne !";
} else {
    echo "Erreur de connexion à la base de données";
}
?> 