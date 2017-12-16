<?php
/* @var $bdd PDO */
session_start();
require_once('config/bdd.conf.php');
require_once('config/init.conf.php');
include('include/header.inc.php');
require_once('include/function.inc.php');
require_once('config/connexion.inc.php');

if ($is_connect == TRUE) {

//verification formulaire
    if (isset($_POST['submit'])) {
        if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['password'])) {



            //requete d'insertion
            $insert = "INSERT INTO utilisateur (nom, prenom, email, mdp) "
                . "VALUES (:nom, :prenom, :email, :password)";

            //bind
            $sth = $bdd->prepare($insert);
            $sth->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
            $sth->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
            $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $sth->bindValue(':password', cryptPassword($_POST['password']), PDO::PARAM_STR);
            if ($sth->execute() == TRUE) {
                $notification = "inscription effectué";
                $_SESSION['inscription_result'] = TRUE;
            } 
            else
            {
                $notification = "Erreur dans l'insertion";
                $_SESSION['inscription_result'] = FALSE;
            }
        } 
        else 
        {
            $notification = "veuillez renseigner tout les champs";
            $_SESSION['inscription_result'] = FALSE;
        }

        $_SESSION['notification_inscription'] = $notification;
        header('Location:inscription.php');
        exit();
    } 
    else 
    {
?>

<div class="container col-md-6">
    <div class="row justify-content-center " >
        <h1 class="mt-5">Inscription </h1></div>
    
    <?php

        //affichage de la notification
        
        if (isset($_SESSION['notification_inscription'])) {
            $inscription_result = $_SESSION['inscription_result'] == TRUE ? 'success' : 'danger';
               ?> 
            
    
    //echo $inscription_result;
                
    <div class="alert alert-<?= $inscription_result ?> alert-dismissible fade show col-md-6" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        
        <strong>
            <?php
                   echo $_SESSION['notification_inscription'];
            ?>
        </strong>
    </div>
    
    <?php
            unset($_SESSION['notification_inscription']);
            unset($_SESSION['inscription_result']);
        }
    ?>
    
    <form action="inscription.php" method="POST" >            
        <div class="form-group">
            <label for="nom" class="col-form-label">nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">
        </div>
        
        <div class="form-group">
            <label for="prenom" class="col-form-label">prenom</label>
            <input type="text" class="form-control" id="nom" name="prenom" placeholder="Prenom">
        </div>
        
        <div class="form-group">
            <label for="email" class="col-form-label">email</label>
            <input type="email" class="form-control" id="nom" name="email" placeholder="exemple@mail.com">
        </div>
        
        <div class="form-group">
            <label for="password" class="col-form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="submit">valider</button>    
        </div>
    </form>
</div>
<link rel="stylesheet" type="text/css" href="css/style.css">


<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="js/dist/jquery.validate.min.js"></script>
<script src="js/dist/localization/messages_fr.min.js"></script>

<?php
        include ('include/footer.inc.php');
    }
} 
else 
{
    header("Location: connexion.php");
}
?>