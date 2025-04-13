<?php

include('hautPage.php');
?>

<style>
    .panneau-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .panneau-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .panneau-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }

    .status-indicator {
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
        margin: 10px 0;
    }

    .status-on {
        background: #28a745;
        color: white;
    }

    .status-off {
        background: #dc3545;
        color: white;
    }

    .message-display {
        background: #000;
        color: #ff0;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
        font-family: 'Courier New', monospace;
        font-size: 1.2em;
        text-align: center;
    }

    .refresh-button {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
        display: block;
        margin: 20px auto;
    }

    .refresh-button:hover {
        background: #0056b3;
    }

    .last-update {
        font-size: 0.9em;
        color: #6c757d;
        text-align: right;
        margin-top: 10px;
    }
</style>

<div class="panneau-container">
    <div class="panneau-header">
        <h1>Panneau d'Affichage</h1>
    </div>

    <div class="panneau-info">
        <h2>État du Panneau</h2>
        <?php
        $is_on = true;
        $status_class = $is_on ? 'status-on' : 'status-off';
        $status_text = $is_on ? 'Allumé' : 'Éteint';
        ?>
        <div class="status-indicator <?php echo $status_class; ?>">
            <?php echo $status_text; ?>
        </div>

        <h2>Emplacement</h2>
        <p>Grand Huit - Le Dragon</p>

        <h2>Message Actuel</h2>
        <div class="message-display">
            Temps d'attente: 45 minutes<br>
            Attraction ouverte jusqu'à 22h00
        </div>
    </div>

    <button class="refresh-button" onclick="refreshData()">
        Actualiser les données
    </button>

    <div class="last-update">
        Dernière mise à jour : <?php echo date('H:i'); ?>
    </div>
</div>

<script>
function refreshData() {
    location.reload();
}
setInterval(refreshData, 300000);
</script>

<?php include('basPage.php'); ?> 