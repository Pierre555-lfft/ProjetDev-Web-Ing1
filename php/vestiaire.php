<?php

include('hautPage.php');
?>

<style>
    .vestiaire-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .vestiaire-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .locker-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: center;
    }

    .locker-number {
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

    .status-free {
        background: #28a745;
        color: white;
    }

    .status-occupied {
        background: #dc3545;
        color: white;
    }

    .code-display {
        font-size: 24px;
        background: #333;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        letter-spacing: 5px;
        margin: 20px 0;
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

<div class="vestiaire-container">
    <div class="vestiaire-header">
        <h1>Vestiaire Connecté</h1>
    </div>

    <div class="locker-info">
        <h2>Votre Casier</h2>
        <div class="locker-number">
            #A-123
        </div>
        <?php
        $is_occupied = true;
        $status_class = $is_occupied ? 'status-occupied' : 'status-free';
        $status_text = $is_occupied ? 'Occupé' : 'Libre';
        ?>
        <div class="status-indicator <?php echo $status_class; ?>">
            <?php echo $status_text; ?>
        </div>
        
        <h3>Code d'accès</h3>
        <div class="code-display">
            1234
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