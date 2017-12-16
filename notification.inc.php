<div class="container">
    <div class="container col-md-6">    
        <?php
//affichage de la notification
        if (isset($_SESSION['notification_connexion'])) {
            $connexion_result = $_SESSION['connexion_result'] == TRUE ? 'success' : 'danger';
            //echo $inscription_result;
            ?>
            <div class="alert alert-<?= $connexion_result ?> alert-dismissible fade show col-md-6" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>
                    <?php
                    echo $_SESSION['notification_connexion'];
                    ?>
                </strong>
            </div>
            <?php
            unset($_SESSION['notification_connexion']);
            unset($_SESSION['connexion_result']);
        }
        ?>

    </div>
</div>