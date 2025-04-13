<?php

include('hautPage.php');
?>

<style>
    .attraction-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .attraction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px solid #eee;
    }

    .status-indicator {
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-open {
        background: #28a745;
        color: white;
    }

    .status-closed {
        background: #dc3545;
        color: white;
    }

    .waiting-time {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin: 20px 0;
    }

    .time-display {
        font-size: 48px;
        color: #333;
        margin: 10px 0;
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

<div class="attraction-container">
    <div class="attraction-header">
        <h1>Carrousel Enchanté</h1>
        <?php
        $is_open = true;
        $status_class = $is_open ? 'status-open' : 'status-closed';
        $status_text = $is_open ? 'Ouvert' : 'Fermé';
        ?>
        <div class="status-indicator <?php echo $status_class; ?>">
            <?php echo $status_text; ?>
        </div>
    </div>

    <div class="waiting-time">
        <h2>Temps d'attente estimé</h2>
        <?php $waiting_time = 10; ?>
        <div class="time-display">
            <?php echo $waiting_time; ?> min
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