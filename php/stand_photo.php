<?php

include('hautPage.php');
?>

<style>
    .photo-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .photo-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .photo-stats {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: center;
    }

    .photo-count {
        font-size: 48px;
        color: #333;
        margin: 10px 0;
    }

    .photo-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }

    .photo-item {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .photo-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
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

<div class="photo-container">
    <div class="photo-header">
        <h1>Stand Photo - La Statue Magique</h1>
    </div>

    <div class="photo-stats">
        <h2>Statistiques du jour</h2>
        <div class="photo-count">
            157 photos
        </div>
        <p>Photos prises aujourd'hui</p>
    </div>

    <div class="photo-gallery">
        <?php
        // Simulation de 6 photos récentes
        for($i = 1; $i <= 6; $i++) {
            echo '<div class="photo-item">
                    <img src="images/photo_statue_'.$i.'.jpg" alt="Photo souvenir '.$i.'">
                  </div>';
        }
        ?>
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