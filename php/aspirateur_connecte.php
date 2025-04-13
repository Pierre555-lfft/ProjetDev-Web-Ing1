<?php

include('hautPage.php');
?>

<style>
    .aspirateur-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .aspirateur-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .aspirateur-info {
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

    .location-info {
        margin: 20px 0;
        padding: 15px;
        background: #e9ecef;
        border-radius: 8px;
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

<div class="aspirateur-container">
    <div class="aspirateur-header">
        <h1>Aspirateur Connecté</h1>
    </div>

    <div class="aspirateur-info">
        <h2>État de l'Aspirateur</h2>
        <?php
        $is_on = true;
        $status_class = $is_on ? 'status-on' : 'status-off';
        $status_text = $is_on ? 'En fonction' : 'À larrêt';
        ?>
        <div class="status-indicator <?php echo $status_class; ?>">
            <?php echo $status_text; ?>
        </div>

        <div class="location-info">
            <h2>Emplacement Actuel</h2>
            <p>Zone : Carrousel Enchanté</p>
            <p>Secteur : Zone famille</p>
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