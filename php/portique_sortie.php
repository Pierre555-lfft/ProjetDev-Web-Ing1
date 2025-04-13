<?php

include('hautPage.php');
?>

<style>
    .portique-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .portique-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .portique-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: center;
    }

    .portique-number {
        font-size: 48px;
        color: #333;
        margin: 10px 0;
    }

    .status-indicator {
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
        margin: 10px 0;
    }

    .status-open {
        background: #28a745;
        color: white;
    }

    .status-closed {
        background: #dc3545;
        color: white;
    }

    .refresh-button {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
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

<div class="portique-container">
    <div class="portique-header">
        <h1>Portique de Sortie</h1>
    </div>

    <div class="portique-info">
        <h2>Numéro du Portique</h2>
        <div class="portique-number">
            #S-01
        </div>
        <?php
        $is_open = true;
        $status_class = $is_open ? 'status-open' : 'status-closed';
        $status_text = $is_open ? 'Ouvert' : 'Fermé';
        ?>
        <div class="status-indicator <?php echo $status_class; ?>">
            <?php echo $status_text; ?>
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