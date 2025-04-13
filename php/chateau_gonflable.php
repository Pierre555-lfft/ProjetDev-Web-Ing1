<?php

include('hautPage.php');
?>

<style>
    .chateau-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .chateau-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .chateau-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: center;
    }

    .status-indicator {
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
        margin: 10px 0;
    }

    .status-inflated {
        background: #28a745;
        color: white;
    }

    .status-deflated {
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

<div class="chateau-container">
    <div class="chateau-header">
        <h1>Château Gonflable</h1>
    </div>

    <div class="chateau-info">
        <h2>État du Château</h2>
        <?php
        $is_inflated = true;
        $status_class = $is_inflated ? 'status-inflated' : 'status-deflated';
        $status_text = $is_inflated ? 'Gonflé' : 'Dégonflé';
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